<?php
/**
 * Decorative fallback for text_and_image when no image is set — brand
 * illustration (interlocking circles), not CMS-editable content.
 */
?>
<svg class="weave" viewBox="0 0 300 300" data-reveal aria-hidden="true">
    <defs>
        <linearGradient id="rois-w1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--green-pale)"/><stop offset="1" stop-color="#C6E5D4"/></linearGradient>
        <linearGradient id="rois-w2" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--green)"/><stop offset="1" stop-color="var(--green-ink)"/></linearGradient>
        <linearGradient id="rois-w3" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--navy-2)"/><stop offset="1" stop-color="var(--navy)"/></linearGradient>
    </defs>
    <circle cx="90" cy="90" r="70" fill="url(#rois-w1)" style="filter: drop-shadow(0 10px 18px rgba(20,42,49,0.1));"/>
    <circle cx="190" cy="90" r="70" fill="url(#rois-w2)" opacity="0.92" style="filter: drop-shadow(0 10px 18px rgba(20,42,49,0.14));"/>
    <circle cx="90" cy="190" r="70" fill="url(#rois-w3)" opacity="0.95" style="filter: drop-shadow(0 10px 18px rgba(20,42,49,0.18));"/>
    <circle cx="190" cy="190" r="70" fill="none" stroke="var(--green-ink)" stroke-width="2"/>
</svg>
