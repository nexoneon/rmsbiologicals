# Glossy Orange & Blue Design System

## Color Palette

### Primary Colors
- **Orange**: `#f97316` (Primary), `#fb923c` (Light), `#ea580c` (Dark)
- **Blue**: `#1e3a8a` (Primary), `#3b82f6` (Light), `#1e40af` (Dark)

### Gradients
- `--gradient-orange`: Orange gradient (135deg)
- `--gradient-blue`: Blue gradient (135deg)
- `--gradient-mixed`: Orange to Blue gradient
- `--gradient-glossy`: White overlay for glossy effect

### Text Colors
- `--text-dark`: #1e293b (Headings)
- `--text-gray`: #64748b (Body text)
- `--text-light`: #94a3b8 (Subtle text)

## Utility Classes

### Buttons

#### Primary Button (Orange)
```html
<button class="btn btn-primary">Click Me</button>
```
- Orange gradient background
- Glossy shadow effect
- Hover: Lifts up with enhanced shadow

#### Secondary Button (Blue)
```html
<button class="btn btn-secondary">Learn More</button>
```
- Blue gradient background
- Subtle shadow
- Hover: Enhanced blue glow

#### Outline Button
```html
<button class="btn btn-outline">Explore</button>
```
- Transparent background
- Orange border
- Hover: Fills with orange gradient

### Cards

#### Glossy Card
```html
<div class="glossy-card">
    <h3>Card Title</h3>
    <p>Card content goes here</p>
</div>
```
- White background
- Gradient top border (orange to blue)
- Hover: Lifts up with shadow
- Rounded corners (16px)

### Badges

#### Orange Badge
```html
<span class="glossy-badge glossy-badge-orange">New</span>
```
- Orange gradient background
- Rounded pill shape
- Glossy shadow

#### Blue Badge
```html
<span class="glossy-badge glossy-badge-blue">Featured</span>
```
- Blue gradient background
- Rounded pill shape
- Glossy shadow

### Text Effects

#### Gradient Text
```html
<h1 class="glossy-text-gradient">Amazing Heading</h1>
```
- Orange to blue gradient text
- Bold font weight
- Eye-catching effect

## Usage Examples

### Hero Section
```html
<section class="hero">
    <div class="container">
        <h1 class="glossy-text-gradient">Welcome to AABT GROUP</h1>
        <p>Your trusted partner in aquaculture and poultry health</p>
        <div class="cta-buttons">
            <a href="#" class="btn btn-primary">Get Started</a>
            <a href="#" class="btn btn-secondary">Learn More</a>
        </div>
    </div>
</section>
```

### Product Card
```html
<div class="glossy-card">
    <span class="glossy-badge glossy-badge-orange">Best Seller</span>
    <h3>Product Name</h3>
    <p>Product description goes here...</p>
    <button class="btn btn-primary">Add to Cart</button>
</div>
```

### Category Badge
```html
<span class="glossy-badge glossy-badge-blue">Aquaculture</span>
```

## Implementation Checklist

✅ **Completed:**
- [x] Updated CSS variables with orange/blue palette
- [x] Created glossy button styles
- [x] Added glossy card component
- [x] Added glossy badge styles
- [x] Added gradient text utility

📋 **To Apply Across Pages:**
1. Replace old `.btn` classes with new glossy buttons
2. Update category badges to use `.glossy-badge-orange` or `.glossy-badge-blue`
3. Wrap content sections in `.glossy-card` for premium look
4. Use `.glossy-text-gradient` for main headings
5. Update hero CTAs with `.btn-primary` and `.btn-secondary`

## Browser Support
- Chrome/Edge: ✅ Full support
- Firefox: ✅ Full support
- Safari: ✅ Full support (with -webkit- prefixes)
- Mobile: ✅ Optimized for touch

## Performance Notes
- Uses CSS variables for easy theming
- Hardware-accelerated transforms
- Optimized animations with cubic-bezier
- Minimal repaints with transform/opacity changes
