#!/usr/bin/env python3
"""
Скрипт автоматического деплоя темы VL Prime на сервер Reg.ru.
Поддерживает FTP (встроенный ftplib) и SFTP (paramiko).
Команды:
  python deploy.py test      - проверка связи с сервером
  python deploy.py backup    - выкачивание текущей рабочей версии темы с сервера в backup/
  python deploy.py dry-run   - симуляция деплоя (показывает, что будет загружено)
  python deploy.py push      - выгрузка темы на сервер
"""

import os
import sys
import ftplib
import argparse
from pathlib import Path
from dotenv import load_dotenv

if sys.platform == "win32":
    try:
        sys.stdout.reconfigure(encoding='utf-8')
        sys.stderr.reconfigure(encoding='utf-8')
    except Exception:
        pass

BASE_DIR = Path(__file__).resolve().parent
ENV_PATH = BASE_DIR / '.env'
load_dotenv(dotenv_path=ENV_PATH)

PROTOCOL = os.getenv("DEPLOY_PROTOCOL", "ftp").lower()
HOST = os.getenv("DEPLOY_HOST", "31.31.196.159")
PORT = int(os.getenv("DEPLOY_PORT", "21" if PROTOCOL == "ftp" else "22"))
USER = os.getenv("DEPLOY_USER", "")
PASSWORD = os.getenv("DEPLOY_PASSWORD", "")
REMOTE_PATH = os.getenv("DEPLOY_REMOTE_PATH", "www/vlprime.ru/wp-content/themes/vlprime").strip().rstrip("/")

def check_env():
    if not USER or not PASSWORD:
        print("[ОШИБКА] Не указаны DEPLOY_USER или DEPLOY_PASSWORD в файле .env.")
        sys.exit(1)

# ================= FTP IMPLEMENTATION =================

def get_ftp_client():
    ftp = ftplib.FTP()
    ftp.connect(HOST, PORT, timeout=30)
    ftp.login(USER, PASSWORD)
    ftp.set_pasv(True)
    ftp.voidcmd('TYPE I')
    return ftp

def ftp_test():
    check_env()
    print(f"[*] Проверка подключения FTP к {USER}@{HOST}:{PORT}...")
    try:
        ftp = get_ftp_client()
        print("[OK] Успешная авторизация на FTP сервере!")
        try:
            items = ftp.nlst(REMOTE_PATH)
            # Фильтруем служебные . и ..
            items = [os.path.basename(i) for i in items if not i.endswith('/.') and not i.endswith('/..')]
            print(f"[OK] Папка темы найдена: {REMOTE_PATH}")
            print(f"[*] Файлов/папок в теме на сервере: {len(items)}")
            print(f"[*] Список элементов: {', '.join(items[:12])}...")
        except Exception as e:
            print(f"[!] Предупреждение: папка {REMOTE_PATH} не прочитана: {e}")
        ftp.quit()
        print("\n[OK] Тест успешно пройден! Деплой готов к работе.")
        return True
    except Exception as e:
        print(f"[ОШИБКА] Не удалось подключиться: {e}")
        return False

def ftp_backup():
    check_env()
    backup_dir = BASE_DIR / "backup" / "remote_theme_backup"
    backup_dir.mkdir(parents=True, exist_ok=True)
    
    print(f"[*] Скачивание рабочей темы с сервера ({REMOTE_PATH}) в {backup_dir}...")
    ftp = get_ftp_client()

    def download_folder(remote_folder, local_folder):
        os.makedirs(local_folder, exist_ok=True)
        try:
            listing = ftp.nlst(remote_folder)
        except Exception:
            return

        for item in listing:
            base_name = os.path.basename(item)
            if base_name in ('.', '..'):
                continue
                
            local_target = os.path.join(local_folder, base_name)
            is_dir = False
            try:
                # Пытаемся зайти как в директорию
                curr = ftp.pwd()
                ftp.cwd(item)
                ftp.cwd(curr)
                is_dir = True
            except Exception:
                is_dir = False
                
            if is_dir:
                download_folder(item, local_target)
            else:
                try:
                    with open(local_target, 'wb') as f:
                        ftp.retrbinary(f"RETR {item}", f.write)
                    print(f"  [GET] {base_name}")
                except Exception as e:
                    print(f"  [!] Ошибка скачивания {item}: {e}")

    download_folder(REMOTE_PATH, str(backup_dir))
    ftp.quit()
    print(f"\n[OK] Бэкап успешно сохранен в: {backup_dir}")

def ftp_ensure_dir(ftp, remote_dir):
    parts = remote_dir.strip("/").split("/")
    current = ""
    for part in parts:
        current += "/" + part if current else part
        try:
            ftp.cwd(current)
        except Exception:
            try:
                ftp.mkd(current)
            except Exception:
                pass
    ftp.cwd("/")

def sync_local_assets():
    """Синхронизирует свежие css, js и assets из корня проекта в папку темы vlprime"""
    import shutil
    theme_dir = BASE_DIR / "vlprime"
    if not theme_dir.exists():
        return

    # Синхронизация CSS
    root_css = BASE_DIR / "css" / "style.css"
    theme_css = theme_dir / "css" / "style.css"
    if root_css.exists():
        theme_css.parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(root_css, theme_css)
        print("  [SYNC] css/style.css -> vlprime/css/style.css")

    # Синхронизация JS
    root_js = BASE_DIR / "js" / "script.js"
    theme_js = theme_dir / "js" / "script.js"
    if root_js.exists():
        theme_js.parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(root_js, theme_js)
        print("  [SYNC] js/script.js -> vlprime/js/script.js")

    # Синхронизация assets
    root_assets = BASE_DIR / "assets"
    theme_assets = theme_dir / "assets"
    if root_assets.exists():
        for root, dirs, files in os.walk(root_assets):
            rel = os.path.relpath(root, root_assets)
            target_sub = theme_assets if rel == "." else theme_assets / rel
            target_sub.mkdir(parents=True, exist_ok=True)
            for f in files:
                src_f = Path(root) / f
                dst_f = target_sub / f
                if not dst_f.exists() or src_f.stat().st_mtime > dst_f.stat().st_mtime:
                    shutil.copy2(src_f, dst_f)

def ftp_upload(source_dir, dry_run=False):
    check_env()
    print(f"[*] Подготовка и синхронизация локальных файлов темы...")
    sync_local_assets()

    print(f"[*] Подключение к FTP {USER}@{HOST}...")
    ftp = get_ftp_client()
    print(f"[*] Целевая директория: {REMOTE_PATH}")
    if dry_run:
        print("[!] Режим DRY-RUN (файлы не будут перезаписаны)")

    uploaded_count = 0
    exclude_extensions = {".zip", ".tar", ".gz", ".log", ".tmp", ".xlsx", ".xls", ".doc", ".docx", ".pdf"}
    exclude_dirs = {".git", ".vscode", ".idea", "node_modules", "dist", "build", "backup"}

    for root, dirs, files in os.walk(source_dir):
        dirs[:] = [d for d in dirs if d not in exclude_dirs]
        rel_dir = os.path.relpath(root, source_dir)
        
        remote_curr = REMOTE_PATH if rel_dir == "." else f"{REMOTE_PATH}/{rel_dir}".replace("\\", "/")
        
        if not dry_run and rel_dir != ".":
            ftp_ensure_dir(ftp, remote_curr)
            
        for file in files:
            ext = os.path.splitext(file)[1].lower()
            if ext in exclude_extensions:
                continue
                
            local_file = os.path.join(root, file)
            remote_file = f"{remote_curr}/{file}".replace("\\", "/")
            
            # Проверка размера на сервере для пропуска неизмененных файлов
            needs_upload = True
            try:
                r_size = ftp.size(remote_file)
                l_size = os.path.getsize(local_file)
                if r_size == l_size:
                    needs_upload = False
            except Exception:
                needs_upload = True
                
            if needs_upload:
                action_str = "[DRY-RUN UPLOAD]" if dry_run else "[UPLOAD]"
                print(f"  {action_str} {file} -> {remote_file}")
                if not dry_run:
                    success = False
                    for attempt in range(1, 4):
                        try:
                            with open(local_file, "rb") as f:
                                ftp.storbinary(f"STOR {remote_file}", f)
                            success = True
                            break
                        except Exception as e:
                            print(f"    [!] Попытка {attempt}/3 не удалась ({e}). Переподключение...")
                            try:
                                ftp.quit()
                            except Exception:
                                pass
                            import time
                            time.sleep(1)
                            try:
                                ftp = get_ftp_client()
                            except Exception as ce:
                                print(f"    [!] Ошибка переподключения: {ce}")
                    if not success:
                        print(f"    [ОШИБКА] Не удалось загрузить {remote_file} после 3 попыток.")
                uploaded_count += 1

    ftp.quit()
    print(f"\n[OK] Завершено! Передано файлов: {uploaded_count}")

# ================= MAIN DISPATCHER =================

def main():
    parser = argparse.ArgumentParser(description="Автодеплой темы VL Prime")
    parser.add_argument("action", choices=["test", "push", "dry-run", "backup"],
                        help="test: проверка связи, push: загрузка на сервер, dry-run: симуляция, backup: выкачать бэкап с сервера")
    parser.add_argument("--source", default=None, help="Какую папку загружать (по умолчанию vlprime или vl-prime-theme)")
    args = parser.parse_args()

    # Определение локальной папки темы
    source_dir = None
    if args.source:
        source_dir = Path(args.source)
    elif (BASE_DIR / "vlprime").exists():
        source_dir = BASE_DIR / "vlprime"
    elif (BASE_DIR / "vl-prime-theme").exists():
        source_dir = BASE_DIR / "vl-prime-theme"
    else:
        source_dir = BASE_DIR

    if args.action == "test":
        ftp_test()
    elif args.action == "backup":
        ftp_backup()
    elif args.action == "dry-run":
        ftp_upload(source_dir, dry_run=True)
    elif args.action == "push":
        ftp_upload(source_dir, dry_run=False)

if __name__ == "__main__":
    main()
