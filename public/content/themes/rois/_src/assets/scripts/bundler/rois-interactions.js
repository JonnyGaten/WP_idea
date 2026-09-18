(function () {
    // Scroll-triggered reveal for every [data-reveal] element (hero copy,
    // section heads, stat/process/globe grids, etc.)
    var revealEls = document.querySelectorAll('[data-reveal]');
    if ('IntersectionObserver' in window) {
        var revealIO = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in');
                    revealIO.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        revealEls.forEach(function (el) { revealIO.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('in'); });
    }

    // Process steps: hovering a stage card highlights its matching line node.
    document.querySelectorAll('.stage').forEach(function (stage) {
        var idx = stage.getAttribute('data-index');
        var node = document.querySelector('.line-node[data-index="' + idx + '"]');
        stage.addEventListener('mouseenter', function () {
            stage.classList.add('active');
            if (node) node.classList.add('active');
        });
        stage.addEventListener('mouseleave', function () {
            stage.classList.remove('active');
            if (node) node.classList.remove('active');
        });
    });

    // Locations: hovering a row highlights its matching globe pin.
    document.querySelectorAll('.site-list .row').forEach(function (row) {
        var idx = row.getAttribute('data-index');
        var node = document.querySelector('.site-node[data-index="' + idx + '"]');
        row.addEventListener('mouseenter', function () {
            row.classList.add('active');
            if (node) node.classList.add('active');
        });
        row.addEventListener('mouseleave', function () {
            row.classList.remove('active');
            if (node) node.classList.remove('active');
        });
    });

    // Stat interrupt: animated count-up once the number scrolls into view.
    var countEl = document.querySelector('.num[data-count-to]');
    if (countEl && 'IntersectionObserver' in window) {
        var counted = false;
        var target = parseInt(countEl.getAttribute('data-count-to'), 10);
        var suffix = countEl.getAttribute('data-suffix') || '';
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        var countIO = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && !counted) {
                    counted = true;

                    if (reduceMotion) {
                        countEl.textContent = target + suffix;
                        return;
                    }

                    var start = null;
                    var duration = 1400;

                    function step(ts) {
                        if (!start) start = ts;
                        var progress = Math.min((ts - start) / duration, 1);
                        var eased = 1 - Math.pow(1 - progress, 3);
                        countEl.textContent = Math.round(eased * target) + suffix;
                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            countEl.textContent = target + suffix;
                        }
                    }

                    requestAnimationFrame(step);
                    countIO.unobserve(countEl);
                }
            });
        }, { threshold: 0.5 });

        countIO.observe(countEl);
    }
})();
