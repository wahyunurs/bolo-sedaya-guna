document.addEventListener('DOMContentLoaded', function() {
            var mainImg = document.getElementById('mainProductImage');
            var thumbs = Array.from(document.querySelectorAll('.thumbnail-item'));

            // build array of image URLs from thumbnails
            var images = thumbs.map(function(t) {
                var img = t.querySelector('img');
                return img ? img.src : null;
            }).filter(Boolean);

            var currentIndex = parseInt(mainImg ? mainImg.dataset.currentIndex : 0) || 0;

            function updateMainImage() {
                if (!mainImg) return;
                if (images.length === 0) return;
                mainImg.src = images[currentIndex];

                // update thumbnail highlight
                thumbs.forEach(function(t) {
                    var idx = parseInt(t.dataset.index);
                    if (idx === currentIndex) {
                        t.classList.add('border-2', 'border-green-500');
                        t.classList.remove('border', 'border-gray-200');
                    } else {
                        t.classList.remove('border-2', 'border-green-500');
                        t.classList.add('border', 'border-gray-200');
                    }
                });
            }

            // click main image to cycle (fallback) and click zones for prev/next
            if (mainImg) {
                mainImg.addEventListener('click', function() {
                    if (images.length === 0) return;
                    currentIndex = (currentIndex + 1) % images.length;
                    updateMainImage();
                });

                // left/right click zones
                var prevZone = document.getElementById('imgPrevZone');
                var nextZone = document.getElementById('imgNextZone');
                if (prevZone) {
                    prevZone.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (images.length === 0) return;
                        currentIndex = (currentIndex - 1 + images.length) % images.length;
                        updateMainImage();
                    });
                }
                if (nextZone) {
                    nextZone.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (images.length === 0) return;
                        currentIndex = (currentIndex + 1) % images.length;
                        updateMainImage();
                    });
                }

                // touch / swipe support on main image
                var touchStartX = null;
                var touchStartY = null;
                var SWIPE_THRESHOLD = 40; // px

                mainImg.addEventListener('touchstart', function(e) {
                    if (!e.touches || e.touches.length === 0) return;
                    touchStartX = e.touches[0].clientX;
                    touchStartY = e.touches[0].clientY;
                }, {
                    passive: true
                });

                mainImg.addEventListener('touchend', function(e) {
                    if (touchStartX === null) return;
                    var touchEndX = (e.changedTouches && e.changedTouches[0]) ? e.changedTouches[0]
                        .clientX : null;
                    var touchEndY = (e.changedTouches && e.changedTouches[0]) ? e.changedTouches[0]
                        .clientY : null;
                    if (touchEndX === null) {
                        touchStartX = null;
                        return;
                    }
                    var dx = touchEndX - touchStartX;
                    var dy = touchEndY - touchStartY;
                    // horizontal swipe and mostly horizontal
                    if (Math.abs(dx) > SWIPE_THRESHOLD && Math.abs(dx) > Math.abs(dy)) {
                        if (dx < 0) { // swipe left -> next
                            currentIndex = (currentIndex + 1) % images.length;
                        } else { // swipe right -> prev
                            currentIndex = (currentIndex - 1 + images.length) % images.length;
                        }
                        updateMainImage();
                    }
                    touchStartX = null;
                    touchStartY = null;
                }, {
                    passive: true
                });
            }

            // click thumbnail to switch
            thumbs.forEach(function(t) {
                t.addEventListener('click', function() {
                    var idx = parseInt(t.dataset.index);
                    if (isNaN(idx)) return;
                    currentIndex = idx;
                    updateMainImage();
                });
            });

            // initialize highlights
            updateMainImage();

            /* ===============================================================
       KODE TAMBAHAN BARU — UNTUK MODAL BELI SEKARANG
    =============================================================== */

    const openBtn = document.getElementById("openBeliSekarang");
    const modalBeli = document.getElementById("modalBeliSekarang");
    const closeBtn = document.getElementById("btnCloseModalBeli");

    if (openBtn && modalBeli) {
        openBtn.addEventListener("click", function() {
            modalBeli.classList.remove("hidden");
            modalBeli.classList.add("flex");
        });
    }

    if (closeBtn && modalBeli) {
        closeBtn.addEventListener("click", function() {
            modalBeli.classList.add("hidden");
            modalBeli.classList.remove("flex");
        });
    }

    // Klik luar modal untuk menutup
    if (modalBeli) {
        modalBeli.addEventListener("click", function(e) {
            if (e.target === modalBeli) {
                modalBeli.classList.add("hidden");
                modalBeli.classList.remove("flex");
            }
        });
    }
});