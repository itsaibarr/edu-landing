# Landing Page Redesign — Design Document
Date: 2026-02-24

## Problem
The current landing pages use "AI-pattern" design conventions: purple/violet gradients everywhere, emoji icons in feature cards, mock UI dashboards with hardcoded statistics, and pill badge components. These patterns make the product feel like a generic AI SaaS tool rather than a credible edtech product.

## Goal
Redesign all three landing pages (home, institutions, students) to match production-level tech landing page standards — specifically the Linear/editorial style: light background, restrained color, editorial typography, no decorative chrome.

## Success Criteria
- No emojis in content
- No gradient backgrounds (gradient allowed only on headline text spans and primary CTA button)
- No mock dashboard/stat cards
- Consistent `white` / `slate-50` alternating sections
- One accent color: `blue-600`
- Clean `border-slate-200` cards, no heavy shadows
- Final CTA sections use `slate-900` dark background

---

## Design System

### Color Palette
| Token | Value | Usage |
|-------|-------|-------|
| Background primary | `white` | Default section bg |
| Background alt | `slate-50` | Alternating sections |
| Background CTA | `slate-900` | Final CTA sections |
| Text heading | `slate-900` | H1, H2, H3 |
| Text body | `slate-600` | Paragraphs |
| Text meta | `slate-400` | Captions, labels |
| Accent | `blue-600` | Eyebrows, icon hover, gradient text |
| Accent gradient | `from-blue-600 to-blue-500` | Hero headline spans only |
| CTA button | `bg-blue-600 hover:bg-blue-700` | Primary button |
| Border | `border-slate-200` | Card borders |

### Typography
- Font: Inter (already loaded)
- Eyebrow labels: `text-xs font-semibold uppercase tracking-widest text-blue-600`
- Section headings: `text-3xl font-bold text-slate-900`
- Hero: `text-5xl md:text-6xl font-bold text-slate-900` with one blue gradient `<span>`
- Body: `text-base text-slate-600 leading-relaxed`

### Components

**`x-badge` (becomes eyebrow label)**
- Remove pill/background styling
- Replace with: `text-xs font-semibold uppercase tracking-widest text-blue-600`

**`x-card`**
- Remove shadows and colored borders
- Replace with: `border border-slate-200 rounded-xl p-6 bg-white`

**`x-btn` primary**
- Remove gradient (`from-violet-600 to-purple-500`)
- Replace with: `bg-blue-600 hover:bg-blue-700 text-white`

**`x-section`**
- Remove Alpine.js scroll-reveal animation (`x-intersect`, opacity-0/translate-y-4)
- Keep `py-20 px-4` wrapper

---

## Page Designs

### Home (`/`)
- Full-screen centered, white background
- Eyebrow: "Early Access" as plain tracking-wide label
- Two path cards: replace 🏫 with building SVG, 🎓 with graduation cap SVG
- Cards: `border-slate-200`, hover → `border-blue-200`
- No changes to copy

### Institutions (`/institutions`)
- **Hero**: Eyebrow + headline (`Make student growth visible.` with blue span) + subtext + two buttons. No mock dashboard.
- **Problem** (white): SVG icons replace emojis. Three-col cards with `border-slate-200`.
- **Solution** (`slate-50`): Two-col layout. Left: text + checklist (unchanged). Right: replace bar chart with a clean bordered panel showing two typographic signal labels (Engagement Index / Growth Score as styled text with descriptions — no fake numbers).
- **Value** (white): Three cards with SVG icons.
- **How It Works** (`slate-50`): Numbered steps, no change structurally.
- **CTA** (`slate-900`): White headline + subtext, Livewire pilot form in white card.

### Students (`/students`)
- **Hero**: Eyebrow + headline (`See your real progress.` with blue span) + subtext + one CTA. No stat card grid.
- **Problem** (white): SVG icons replace emojis. Three-col cards.
- **Solution** (`slate-50`): Three cards, SVG icons, clean borders.
- **Value** (white): Three items, SVG icons.
- **CTA** (`slate-900`): White headline + subtext, Livewire waitlist form in white card.

---

## What Does NOT Change
- All copy (headlines, body text, CTAs)
- Page structure and section order
- Livewire form components and logic
- Routes and controllers
- Three-page navigation structure
