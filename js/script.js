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

});
