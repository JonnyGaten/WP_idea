<?php
/**
 * Decorative element for the hero_intro module — brand illustration, not
 * CMS-editable content. Ported directly from the design concept.
 */
?>
<svg viewBox="0 0 420 480" width="100%" height="100%" aria-hidden="true">
    <defs>
        <linearGradient id="rois-g1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--green)"/><stop offset="1" stop-color="var(--green-ink)"/></linearGradient>
        <linearGradient id="rois-g2" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="var(--navy-2)"/><stop offset="1" stop-color="var(--navy)"/></linearGradient>
        <linearGradient id="rois-g3" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#FFFFFF"/><stop offset="1" stop-color="var(--cream-2)"/></linearGradient>
        <radialGradient id="rois-floorGlow" cx="50%" cy="50%" r="50%"><stop offset="0" stop-color="rgba(20,42,49,0.16)"/><stop offset="1" stop-color="rgba(20,42,49,0)"/></radialGradient>
    </defs>
    <ellipse cx="180" cy="430" rx="160" ry="26" fill="url(#rois-floorGlow)"/>
    <g transform="translate(60,40) rotate(-8)" style="filter: drop-shadow(0 14px 18px rgba(20,42,49,0.18));">
        <rect x="0" y="0" width="46" height="200" rx="23" fill="var(--green-pale)"/>
        <rect x="8" y="16" width="30" height="120" rx="6" fill="url(#rois-g1)"/>
        <rect x="14" y="0" width="18" height="20" fill="var(--navy)"/>
        <rect x="18" y="-26" width="10" height="30" fill="#9BB8B2"/>
    </g>
    <g transform="translate(150,10) rotate(4)" style="filter: drop-shadow(0 18px 22px rgba(14,42,56,0.28));">
        <rect x="0" y="0" width="54" height="230" rx="27" fill="url(#rois-g2)"/>
        <rect x="10" y="20" width="34" height="150" rx="6" fill="var(--green)" opacity="0.92"/>
        <rect x="16" y="0" width="22" height="24" fill="var(--green-ink)"/>
        <rect x="21" y="-30" width="12" height="34" fill="#4C6068"/>
    </g>
    <g transform="translate(250,60) rotate(-4)" style="filter: drop-shadow(0 14px 18px rgba(20,42,49,0.18));">
        <rect x="0" y="0" width="48" height="190" rx="24" fill="url(#rois-g3)" stroke="var(--line)" stroke-width="2"/>
        <rect x="9" y="18" width="30" height="110" rx="6" fill="var(--green-pale)"/>
        <rect x="14" y="0" width="20" height="22" fill="var(--navy)"/>
        <rect x="19" y="-28" width="10" height="32" fill="#9BB8B2"/>
    </g>
    <circle cx="330" cy="340" r="60" fill="var(--green)" opacity="0.15"/>
    <circle cx="60" cy="380" r="40" fill="var(--navy)" opacity="0.08"/>
</svg>
