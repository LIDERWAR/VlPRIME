document.addEventListener('DOMContentLoaded', () => {
    // --- Mobile Menu Toggle ---
    const burgerMenu = document.querySelector('.burger-menu');
    const nav = document.querySelector('.nav');

    if (burgerMenu && nav) {
        burgerMenu.addEventListener('click', () => {
            nav.classList.toggle('active');

            // Optional: Animate burger icon
            burgerMenu.classList.toggle('open');
        });

        // Close menu when clicking a link
        nav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
                burgerMenu.classList.remove('open');
            });
        });
    }

    // --- Header Scroll Effect ---
    const header = document.querySelector('.header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // --- Active Link Highlighting ---
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav__link');

    const observerOptions = {
        root: null,
        rootMargin: '-20% 0px -50% 0px', // Trigger when section is in the middle of viewport
        threshold: 0
    };

    // Helper: Find link corresponding to current page path
    const getCurrentPageLink = () => {
        const currentPath = window.location.pathname;
        let found = null;

        // Handle "root" / vs index.html normalization
        const isRoot = currentPath === '/' || currentPath.endsWith('/index.html');

        navLinks.forEach(link => {
            try {
                // Use URL object to parse absolute hrefs
                const url = new URL(link.href);

                // Only consider links without hashes (pure page links)
                if (url.hash === '') {
                    if (url.pathname === currentPath) {
                        found = link;
                    } else if (isRoot && (url.pathname === '/' || url.pathname.endsWith('/index.html'))) {
                        found = link; // Match root variations
                    }
                }
            } catch (e) { }
        });
        return found;
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // 1. Try to find specific link by Section ID
                const id = entry.target.getAttribute('id');
                let activeLink = null;

                if (id) {
                    activeLink = document.querySelector(`.nav__link[href*="#${id}"]`);
                }

                // 2. Fallback: If no specific section link found, use Current Page Link
                // This ensures "Services" stays active on service.html even when scrolling unmapped sections
                if (!activeLink) {
                    activeLink = getCurrentPageLink();
                }

                // 3. Apply Active Class
                if (activeLink) {
                    navLinks.forEach(link => link.classList.remove('active'));
                    activeLink.classList.add('active');
                }
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        sectionObserver.observe(section);
    });


    // --- Reviews Slider: Infinite Loop + Drag ---
    const slider = document.querySelector('.reviews__slider');

    if (slider) {
        // 1. Clone content to create infinite effect (3 sets)
        const originalContent = slider.innerHTML;
        slider.innerHTML = originalContent + originalContent + originalContent;

        // Re-query cards after cloning
        let cards = document.querySelectorAll('.review-card');
        const sliderContainer = slider; // Reference for clarity

        let isAnimating = false; // Flag to prevent scroll interruptions

        // 2. Initialize Scroll Position to the Middle Set
        const initScroll = () => {
            const totalWidth = slider.scrollWidth;
            const oneSetWidth = totalWidth / 3;
            // Only set if at start (first load)
            if (slider.scrollLeft < 50) {
                slider.scrollLeft = oneSetWidth;
            }
        };
        // Small timeout to ensure layout is ready
        setTimeout(initScroll, 10);


        // 3. Infinite Scroll Jump Logic (Index-based + Precision Delta + Snap Disabling)
        const handleInfiniteScroll = () => {
            if (isAnimating) return;

            // Use getBoundingClientRect for sub-pixel precision
            const sliderRect = slider.getBoundingClientRect();
            const sliderCenter = sliderRect.left + sliderRect.width / 2;

            let closestIndex = -1;
            let minDistance = Infinity;

            // Find the card visually closest to center
            cards.forEach((card, index) => {
                const cardRect = card.getBoundingClientRect();
                const cardCenter = cardRect.left + cardRect.width / 2;
                const dist = Math.abs(sliderCenter - cardCenter);

                if (dist < minDistance) {
                    minDistance = dist;
                    closestIndex = index;
                }
            });

            if (closestIndex === -1) return;

            const totalCards = cards.length;
            const oneSetCount = totalCards / 3;
            let delta = 0;

            // Warp Logic: Always keep us in the Middle Set
            if (closestIndex < oneSetCount) {
                // Warp Forward: Set 1 -> Set 2
                if (closestIndex + oneSetCount < totalCards) {
                    const currentCard = cards[closestIndex];
                    const targetCard = cards[closestIndex + oneSetCount];
                    // Calculate precise delta based on screen positions
                    delta = targetCard.getBoundingClientRect().left - currentCard.getBoundingClientRect().left;
                }
            } else if (closestIndex >= oneSetCount * 2) {
                // Warp Backward: Set 3 -> Set 2
                if (closestIndex - oneSetCount >= 0) {
                    const currentCard = cards[closestIndex];
                    const targetCard = cards[closestIndex - oneSetCount];
                    // Calculate precise delta (negative direction)
                    delta = -(currentCard.getBoundingClientRect().left - targetCard.getBoundingClientRect().left);
                }
            }

            if (delta !== 0) {
                // EXECUTE WARP

                // 1. Disable Transitions globally on the slider to prevent "jump" from scale animations
                slider.style.transition = 'none';
                cards.forEach(c => c.style.transition = 'none');

                // 2. Disable Snap 
                slider.classList.add('active');

                // 3. Apply Scroll Instantaneously
                slider.scrollLeft += delta;

                // 4. Force Update Active Slide Immediately at new position
                // This ensures the target slide is ALREADY scaled when we turn transitions back on
                updateActiveSlide();

                // 5. Restore Transitions & Snap after render cycle
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        slider.classList.remove('active');
                        // Restore transitions
                        slider.style.transition = '';
                        cards.forEach(c => c.style.transition = '');
                    });
                });
            }
        };

        // Debounce timer for scroll end detection
        let scrollTimeout;

        slider.addEventListener('scroll', () => {
            updateActiveSlide();

            // Only trigger Infinite Scroll warp when scrolling STOPS
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if (!isAnimating) {
                    handleInfiniteScroll();
                }
            }, 60);
        });


        // 4. Drag Logic (Delta-based to support jumps)
        let isDown = false;
        let wasDragged = false;
        let startPageX;
        let lastPageX;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            wasDragged = false; // Reset drag state
            slider.classList.add('active'); // Disables snap via CSS for free drag
            startPageX = e.pageX;
            lastPageX = e.pageX;

            // Cancel any pending warp
            clearTimeout(scrollTimeout);
        });

        const stopDrag = () => {
            isDown = false;
            slider.classList.remove('active'); // Re-enables snap

            // Manually trigger check after drag release to handle "fling to boundary"
            // But let the scroll event debounce handle it naturally as momentum settles
        };

        slider.addEventListener('mouseleave', stopDrag);
        slider.addEventListener('mouseup', stopDrag);

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();

            // Check threshold to avoid treating micro-clicks as drags
            if (!wasDragged && Math.abs(e.pageX - startPageX) < 5) return;

            wasDragged = true; // Mark as dragged only after threshold
            const currentX = e.pageX;
            const walk = (currentX - lastPageX) * 2; // Speed multiplier
            slider.scrollLeft -= walk;
            lastPageX = currentX;
        });

        // Shared Smooth Scroll Function
        const performSmoothScroll = (amount) => {
            if (isAnimating) return;

            // Disable snap and jump logic to allow smooth scroll
            slider.classList.add('active');
            isAnimating = true;
            clearTimeout(scrollTimeout); // Cancel pending warps

            slider.scrollBy({
                left: amount,
                behavior: 'smooth'
            });

            // Re-enable snap after scroll finishes
            setTimeout(() => {
                isAnimating = false;

                // Immediately check infinite scroll to ensure we are in a valid zone
                handleInfiniteScroll();

                // Re-enable snap after warp is processed
                requestAnimationFrame(() => {
                    slider.classList.remove('active');
                });
            }, 800);
        };

        // 4.5 Click to Center (Ignore if dragged)
        cards.forEach(card => {
            card.addEventListener('click', () => {
                if (wasDragged) return;

                const sliderRect = slider.getBoundingClientRect();
                const cardRect = card.getBoundingClientRect();
                const sliderCenter = sliderRect.width / 2;
                const cardCenter = cardRect.left - sliderRect.left + (cardRect.width / 2);
                const offset = cardCenter - sliderCenter;

                performSmoothScroll(offset);
            });
        });


        // 5. Mouse Wheel Support
        let wheelTimeout;
        slider.addEventListener('wheel', (e) => {
            e.preventDefault();

            // Disable snap temporarily for smooth scrolling
            slider.classList.add('active');
            clearTimeout(scrollTimeout); // Prevent warp during active wheeling

            // Reset snap after scrolling stops
            clearTimeout(wheelTimeout);
            wheelTimeout = setTimeout(() => {
                slider.classList.remove('active');
                // The scroll event listener will handle the Infinite Scroll warp via its own debounce
            }, 150);

            // Scroll horizontally
            slider.scrollLeft += e.deltaY + e.deltaX;
        }, { passive: false });


        // 6. Center Slide Magnification
        function updateActiveSlide() {
            const sliderRect = slider.getBoundingClientRect();
            const center = sliderRect.left + (sliderRect.width / 2);

            let closestCard = null;
            let minDistance = Infinity;

            cards.forEach(card => {
                const cardRect = card.getBoundingClientRect();
                const cardCenter = cardRect.left + (cardRect.width / 2);
                const distance = Math.abs(center - cardCenter);

                if (distance < minDistance) {
                    minDistance = distance;
                    closestCard = card;
                }
            });

            cards.forEach(card => card.classList.remove('active-slide'));
            if (closestCard) {
                closestCard.classList.add('active-slide');
            }
        }

        // Listeners for Highlight
        window.addEventListener('resize', () => {
            initScroll();
            updateActiveSlide();
        });

        // 7. Auto-Slide Logic (Every 5 seconds)
        let autoSlideInterval;

        const startAutoSlide = () => {
            stopAutoSlide(); // Ensure no duplicate intervals
            autoSlideInterval = setInterval(() => {
                if (isDown || isAnimating) return; // Don't slide if user is interacting

                // Get single card width including gap
                // Let's scroll by one card width (approximate or precise)
                const cardWidth = cards[0].offsetWidth;
                const gap = parseFloat(window.getComputedStyle(slider).gap) || 20;
                const slideAmount = cardWidth + gap;

                performSmoothScroll(slideAmount);
            }, 5000);
        };

        const stopAutoSlide = () => {
            clearInterval(autoSlideInterval);
        };

        // Pause on hover/interaction
        slider.addEventListener('mouseenter', stopAutoSlide);
        slider.addEventListener('mouseleave', startAutoSlide);
        slider.addEventListener('mousedown', stopAutoSlide);

        // Start initially
        startAutoSlide();
    }


    // --- FAQ Accordion Logic ---
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const header = item.querySelector('.faq-item__header');
        const content = item.querySelector('.faq-item__content');

        header.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');

            // Close all others (Accordion behavior)
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-item__header').setAttribute('aria-expanded', 'false');
                    otherItem.querySelector('.faq-item__content').setAttribute('aria-hidden', 'true');

                    // For smooth closing, we can explicitly set height to 0 if needed, but CSS max-height handles it well enough
                    // If we wanted perfect animation we'd use scrollHeight
                    otherItem.querySelector('.faq-item__content').style.maxHeight = null;
                }
            });

            // Toggle current
            item.classList.toggle('active');

            if (!isOpen) {
                // Opening
                header.setAttribute('aria-expanded', 'true');
                content.setAttribute('aria-hidden', 'false');
                content.style.maxHeight = content.scrollHeight + "px";
            } else {
                // Closing
                header.setAttribute('aria-expanded', 'false');
                content.setAttribute('aria-hidden', 'true');
                content.style.maxHeight = null;
            }
        });
    });

    // --- Service Page Calculator ---
    const serviceBlocks = document.querySelectorAll('.service-block');
    const globalSummaryList = document.getElementById('global-summary-list');
    const globalTotalValue = document.getElementById('global-total-value');

    // Helper to format currency
    const formatPrice = (price) => {
        return new Intl.NumberFormat('ru-RU').format(price) + ' ₽';
    };

    const updateGlobalSummary = () => {
        const allCheckboxes = document.querySelectorAll('.calc-checkbox:checked');
        let totalGlobal = 0;

        if (globalSummaryList) {
            globalSummaryList.innerHTML = ''; // Clear current

            if (allCheckboxes.length === 0) {
                globalSummaryList.innerHTML = '<div class="summary-empty">Ничего не выбрано</div>';
            } else {
                allCheckboxes.forEach(cb => {
                    const price = parseInt(cb.dataset.price || 0);
                    const name = cb.dataset.service || 'Услуга';
                    totalGlobal += price;

                    const itemEl = document.createElement('div');
                    itemEl.className = 'summary-item';

                    // Info wrapper
                    const infoDiv = document.createElement('div');
                    infoDiv.className = 'summary-item__info'; // Add class for styling if needed
                    infoDiv.style.flex = '1';

                    const nameEl = document.createElement('div');
                    nameEl.className = 'summary-item__name';
                    nameEl.textContent = name;

                    const priceEl = document.createElement('div');
                    priceEl.className = 'summary-item__price';
                    priceEl.textContent = formatPrice(price);

                    infoDiv.appendChild(nameEl);
                    infoDiv.appendChild(priceEl);

                    // Remove Button
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'summary-remove-btn';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.title = 'Удалить';

                    removeBtn.addEventListener('click', (e) => {
                        e.stopPropagation(); // Prevent bubbling layout issues
                        cb.checked = false;
                        cb.dispatchEvent(new Event('change'));
                    });

                    itemEl.appendChild(infoDiv);
                    itemEl.appendChild(removeBtn);
                    globalSummaryList.appendChild(itemEl);
                });
            }
        }

        if (globalTotalValue) globalTotalValue.textContent = formatPrice(totalGlobal);
    };

    if (serviceBlocks.length > 0) {
        serviceBlocks.forEach(block => {
            const checkboxes = block.querySelectorAll('.calc-checkbox');
            const totalDisplay = block.querySelector('.calc-total__value');
            const bookBtn = block.querySelector('.calc-book-btn');

            const calculateLocalTotal = () => {
                let total = 0;
                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        total += parseInt(cb.dataset.price || 0);
                    }
                });

                // Update Local Total Text
                if (total > 0) {
                    totalDisplay.textContent = `от ${formatPrice(total)}`;
                    totalDisplay.style.color = 'var(--color-primary)';
                    bookBtn.removeAttribute('disabled');
                    bookBtn.textContent = 'Записаться';
                } else {
                    totalDisplay.textContent = '0 ₽';
                    totalDisplay.style.color = 'white';
                    bookBtn.setAttribute('disabled', 'true');
                    bookBtn.textContent = 'Выберите услуги';
                }

                // Update Global
                updateGlobalSummary();
            };

            // Event Listeners
            checkboxes.forEach(cb => {
                cb.addEventListener('change', calculateLocalTotal);
            });

            // Booking Button Click
            if (bookBtn) {
                bookBtn.addEventListener('click', () => {
                    const selectedServices = [];
                    checkboxes.forEach(cb => {
                        if (cb.checked) selectedServices.push(cb.dataset.service);
                    });

                    // Scroll to booking form
                    const bookingSection = document.getElementById('booking');
                    if (bookingSection) {
                        bookingSection.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            // Init Local
            calculateLocalTotal();
        });

        // Init Global
        updateGlobalSummary();
    }

    // --- Floating Scroll Buttons ---
    const scrollNav = document.querySelector('.scroll-nav');
    const scrollTopBtn = document.getElementById('scrollTop');
    const scrollBottomBtn = document.getElementById('scrollBottom');

    if (scrollNav && scrollTopBtn && scrollBottomBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollNav.classList.add('visible');
            } else {
                scrollNav.classList.remove('visible');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        scrollBottomBtn.addEventListener('click', () => {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        });
    }

    // --- Promo Logic from URL ---
    const handlePromoParams = () => {
        const urlParams = new URLSearchParams(window.location.search);
        const promo = urlParams.get('promo');

        if (!promo) return;

        // 1. Free Diagnostics
        if (promo === 'free_diagnostics') {
            // Find input in "service-mechanical" block
            const targetInput = document.querySelector('input[data-service="Диагностика подвески"]');
            if (targetInput) {
                // Apply 100% discount
                targetInput.dataset.price = "0";

                // Update visual price
                const label = targetInput.closest('.calc-option');
                const priceSpan = label.querySelector('.calc-option__price');
                if (priceSpan) {
                    priceSpan.textContent = "Бесплатно";
                    priceSpan.style.color = "var(--color-primary)";
                    priceSpan.style.fontWeight = "bold";
                }

                // Auto-select
                if (!targetInput.checked) {
                    targetInput.checked = true;
                    // Trigger calculation
                    targetInput.dispatchEvent(new Event('change'));
                }
            }
        }

        // 2. Oil Service Discount (15%)
        else if (promo === 'oil_discount') {
            const oilInputs = [
                document.querySelector('input[data-service="Замена масла ДВС"]'),
                document.querySelector('input[data-service="Замена масляного фильтра"]')
            ].filter(el => el !== null);

            oilInputs.forEach(input => {
                // Apply 15% discount
                const originalPrice = parseInt(input.dataset.price || 0);
                const newPrice = Math.round(originalPrice * 0.85);
                input.dataset.price = newPrice.toString();

                // Update visual price with strikethrough
                const label = input.closest('.calc-option');
                const priceSpan = label.querySelector('.calc-option__price');
                if (priceSpan) {
                    priceSpan.innerHTML = `<span style="text-decoration: line-through; opacity: 0.7; margin-right: 8px;">от ${formatPrice(originalPrice)}</span><span style="color: var(--color-primary);">от ${formatPrice(newPrice)}</span>`;
                }

                // Auto-select
                if (!input.checked) {
                    input.checked = true;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }
    };

    // Run after a small delay to ensure DOM is fully ready and scroll is complete
    setTimeout(handlePromoParams, 100);

    // --- Telegram Form Submission ---
    const bookingForm = document.querySelector('.booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = bookingForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.textContent = 'Отправка...';
            submitBtn.disabled = true;

            // 1. Collect Form Data
            const name = bookingForm.querySelector('input[type="text"]').value;
            const phone = bookingForm.querySelector('input[type="tel"]').value;
            const model = bookingForm.querySelector('select').value;

            // 2. Collect Calculator Data
            const selectedServices = [];
            let totalPrice = 0;
            const checkedBoxes = document.querySelectorAll('.calc-checkbox:checked');

            checkedBoxes.forEach(cb => {
                const serviceName = cb.dataset.service;
                const servicePrice = parseInt(cb.dataset.price || 0);
                selectedServices.push(`${serviceName} - ${formatPrice(servicePrice)}`);
                totalPrice += servicePrice;
            });

            // 3. Format Message
            // Use simple formatting for the URL
            const startLine = `👋 Новая заявка с сайта VL Prime`;
            const clientLine = `👤 Клиент: ${name}`;
            const phoneLine = `📱 Телефон: ${phone}`;
            const carLine = `🚗 Авто: ${model || 'Не выбран'}`;
            const servicesHeader = `🛠 Услуги:`;
            const servicesList = selectedServices.length > 0 ? selectedServices.join('\n') : 'Услуги не выбраны';
            const totalLine = `💰 Итого: ${formatPrice(totalPrice)}`;

            const fullText = `${startLine}\n\n${clientLine}\n${phoneLine}\n${carLine}\n\n${servicesHeader}\n${servicesList}\n\n${totalLine}`;

            // 4. Send to Telegram (Direct Link)
            // Replace with your Telegram Username (without @) or Phone Number (international format without +)
            // Example: 'sergey_vl' or '79991234567'
            // best practice is using username to ensure 'text' parameter works correctly across devices
            const TARGET_CONTACT = '79266262662';

            /*
            if (TARGET_CONTACT === 'YOUR_TELEGRAM_USERNAME') {
                alert('Пожалуйста, настройте TARGET_CONTACT в script.js');
                submitBtn.textContent = originalBtnText;
                submitBtn.disabled = false;
                return;
            }
            */

            // Encode text for URL
            const encodedText = encodeURIComponent(fullText);
            // Important: For phone numbers, t.me requires a '+' prefix (e.g. t.me/+7999...)
            // If it's a username, the '+' is usually not needed, but we optimized for phone here as per request.
            // We will strip any existing '+' just in case and add it back to ensure consistency, 
            // or better yet, just blindly add it if it looks like a number.

            let telegramUrl;
            if (/^\d+$/.test(TARGET_CONTACT)) {
                telegramUrl = `https://t.me/+${TARGET_CONTACT}?text=${encodedText}`;
            } else {
                telegramUrl = `https://t.me/${TARGET_CONTACT}?text=${encodedText}`;
            }

            // Open Telegram
            window.open(telegramUrl, '_blank');

            // Reset form UI
            submitBtn.textContent = originalBtnText;
            submitBtn.disabled = false;
            bookingForm.reset();
            document.querySelectorAll('.calc-checkbox:checked').forEach(cb => {
                cb.checked = false;
                cb.dispatchEvent(new Event('change'));
            });
            document.querySelectorAll('.calc-checkbox:checked').forEach(cb => {
                cb.checked = false;
                cb.dispatchEvent(new Event('change'));
            });
        });
    }

    // --- Main Services Spotlight Effect ---
    const msCards = document.querySelectorAll('.ms-card');

    if (msCards.length > 0) {
        msCards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);

                // Optional: Dynamic icon color or subtle parallax could be added here
            });
        });
    }

    // --- Lightbox Logic ---
    const setupLightbox = () => {
        // 1. Create Lightbox Elements
        const lightbox = document.createElement('div');
        lightbox.className = 'lightbox';

        const img = document.createElement('img');
        img.className = 'lightbox__img';
        img.alt = 'Enlarged Image';

        const closeBtn = document.createElement('div');
        closeBtn.className = 'lightbox__close';
        closeBtn.innerHTML = '&times;';

        lightbox.appendChild(img);
        lightbox.appendChild(closeBtn);
        document.body.appendChild(lightbox);

        // 2. State
        let isOpen = false;

        const openLightbox = (src) => {
            img.src = src;
            lightbox.style.display = 'flex';
            // Force reflow for transition
            lightbox.offsetHeight;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scroll
            isOpen = true;
        };

        const closeLightbox = () => {
            lightbox.classList.remove('active');
            setTimeout(() => {
                lightbox.style.display = 'none';
                img.src = '';
                document.body.style.overflow = '';
                isOpen = false;
            }, 300); // Match transition duration
        };

        // 3. Event Listeners

        // Triggers: Target all images in article bodies and explicit .zoomable images
        // We use delegation or just query all existing ones
        const images = document.querySelectorAll('.article-body img, img.zoomable, .case-images-grid img');

        images.forEach(image => {
            image.addEventListener('click', (e) => {
                e.preventDefault(); // In case it's inside a link
                e.stopPropagation();
                openLightbox(image.src);
            });
        });

        // Close on Click Outside or Close Button
        lightbox.addEventListener('click', (e) => {
            if (e.target !== img) {
                closeLightbox();
            }
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (isOpen && e.key === 'Escape') {
                closeLightbox();
            }
        });
    };

    // Init Lightbox
    setupLightbox();

});
