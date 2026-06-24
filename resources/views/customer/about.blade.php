@extends('layouts.customer')

@section('title', 'The Heritage of Excellence')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about-premium.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about-heritage.css') }}?v={{ time() }}">
@endpush

@section('content')

    <div class="about-heritage">

        {{-- ── HERO SECTION ── --}}
        <section class="hero-cinematic">
            <div class="hero-bg"></div>
            <div class="hero-smoke"></div>
            <div class="hero-overlay"></div>
            <div class="hero-watermark">1962</div>

            <div class="hero-content">
                <span class="hero-eyebrow reveal-text">Surabaya ● Since 1962</span>

                <h1 class="hero-title reveal-text">
                    Legacy Rolled<br>
                    Into <span>Perfection</span>
                </h1>

                <p class="hero-desc reveal-text">
                    Our story is one of patience, heritage, and the pursuit of uncompromising quality.
                    For over sixty years, we have married Javanese volcanic soil with the soul of master craftsmanship.
                </p>

                <a href="#story" class="hero-cta reveal-text">
                    <span>Begin the Journey</span>
                    <span class="hero-cta__arrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12l7 7 7-7" />
                        </svg>
                    </span>
                </a>
            </div>

            <div class="reveal about-hero__visual">
                <div class="about-hero__collage">
                    <div class="about-hero__img-primary">
                        <img src="{{ asset('images/grha_wismilak_hero.png') }}" alt="Grha Wismilak Heritage Building">
                    </div>
                    <div class="about-hero__img-secondary">
                        <img src="{{ asset('images/wismilak.jpeg') }}" alt="Wismilak Heritage Legacy">
                    </div>
                </div>
            </div>
        </section>

        {{-- ── BRAND STORY (THE PHILOSOPHY) SECTION ── --}}
        <section class="editorial-section" id="story">
            <div class="philosophy__container">
                <div class="reveal philosophy__label">The Philosophy</div>
                
                <blockquote class="reveal philosophy__statement">
                    "Quality is not a metric, but a devotion."
                </blockquote>
                
                <div class="reveal philosophy__showcase">
                    <img src="{{ asset('images/wismilak.jpeg') }}" alt="Wismilak Heritage Founders & Visionaries">
                </div>
                
                <div class="philosophy__text-grid">
                    <p class="reveal philosophy__paragraph">
                        Wismilak was never just a business; it was a gathering of visionaries. In 1962, amidst the
                        vibrant culture of Surabaya, Lie Koen Lie and Oei Bian Hok embarked on a singular mission:
                        to master the intricate balance of Indonesian tobacco and artisanal craftsmanship. Their
                        philosophy was simple yet profound—quality is not a metric, but a devotion.
                    </p>
                    <p class="reveal philosophy__paragraph">
                        Today, that devotion lives in every hand-rolled cigar we produce. From the volcanic heights
                        of East Java to the global stage of luxury connoisseurs, we remain the stewards of a heritage
                        that values patience over speed, and soul over mass production.
                    </p>
                </div>
            </div>
        </section>




        {{-- ── ANATOMY OF MASTERY ── --}}
        <section class="anatomy-section">
            <div class="max-w-editorial">
                <div class="timeline-header">
                    <span class="editorial-label reveal-text">The Blueprint</span>
                    <h2 class="editorial-title reveal-text">Anatomy of <em>Mastery</em></h2>
                </div>

                <div class="anatomy-container">
                    <div class="anatomy-list">
                        <div class="anatomy-point reveal-text">
                            <h4>The Wrapper</h4>
                            <p>The silken Javano leaf, chosen for its flawless texture and rich, amber hue. It provides the
                                initial aroma and the elegant finish.</p>
                        </div>
                        <div class="anatomy-point reveal-text">
                            <h4>The Binder</h4>
                            <p>A resilient leaf from the Besuki fields, responsible for the structural integrity and the
                                consistent, smooth draw.</p>
                        </div>
                    </div>

                    <div class="anatomy-visual img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/anatomi.png') }}');">
                    </div>

                    <div class="anatomy-list">
                        <div class="anatomy-point reveal-text">
                            <h4>The Filler</h4>
                            <p>A secret blend of aged Indonesian long-fillers, providing the complex heart and the lingering
                                notes of earth and spice.</p>
                        </div>
                        <div class="anatomy-point reveal-text">
                            <h4>The Cap</h4>
                            <p>Precision-cut and applied by hand, the final seal that ensures the perfect airflow and
                                connoisseur-level experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- ── THE TERROIR (EXTREME) ── --}}
        <section class="terroir-section">
            <div class="terroir-bg-extreme img-placeholder"
                style="background-image: url('{{ asset('images/teroirr.jpeg') }}');">
            </div>

            <div class="max-w-editorial">
                <div class="timeline-header" style="text-align: center;">
                    <span class="editorial-label reveal-text">Source of Life</span>
                    <h2 class="editorial-title reveal-text">Nurtured by <em>Volcanic Soil</em></h2>
                </div>

                <div class="terroir-float-grid">
                    <div class="terroir-card-float reveal-text">
                        <span class="card-num">01</span>

                        <div class="card-img-mini img-placeholder"
                            style="background-image: url('{{ asset('images/jember.jpg') }}');">
                        </div>

                        <h4>Jember</h4>
                        <p>The golden belt of East Java, where the soil is rich with volcanic minerals, producing the
                            world's most silken Javano wrappers.</p>
                    </div>

                    <div class="terroir-card-float reveal-text" style="margin-top: 5rem;">
                        <span class="card-num">02</span>

                        <div class="card-img-mini img-placeholder"
                            style="background-image: url('{{ asset('images/madura.jpg') }}');">
                        </div>

                        <h4>Madura</h4>
                        <p>An island sculpted by sun and sea salt, yielding leaves with unmatched strength and a deep,
                            complex soul.</p>
                    </div>

                    <div class="terroir-card-float reveal-text">
                        <span class="card-num">03</span>

                        <div class="card-img-mini img-placeholder"
                            style="background-image: url('{{ asset('images/bojonegoro.jpg') }}');">
                        </div>

                        <h4>Bojonegoro</h4>
                        <p>Where the mist of the Bengawan Solo river nurtures the tobacco, resulting in a legendary
                            smoothness and aroma.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── CRAFTSMANSHIP PROCESS ── --}}
        <section class="craft-section">
            <div class="max-w-editorial">
                <div class="craft__split-grid">
                    <!-- Left Sticky Column -->
                    <div class="craft__sticky-side reveal">
                        <div class="craft__label">Soil to Soul</div>
                        <h2 class="craft__title">The Four Pillars of <em>Craft</em></h2>
                        <p class="craft__subtitle">Every cigar is a masterwork, marrying Indonesian tobacco artistry with uncompromising luxury.</p>
                    </div>

                    <!-- Right Scrollable Column -->
                    <div class="craft__step-list">
                        <div class="craft__step-card reveal">
                            <span class="craft__step-num">01</span>
                            <div class="craft__step-content">
                                <h4>Selection</h4>
                                <p>Only the top 5% of each harvest survives our rigorous inspection. Every leaf is evaluated for its silhouette, oil content, and natural aroma before being chosen.</p>
                            </div>
                        </div>
                        <div class="craft__step-card reveal">
                            <span class="craft__step-num">02</span>
                            <div class="craft__step-content">
                                <h4>Fermentation</h4>
                                <p>Selected leaves undergo a slow fermentation process lasting 45 days, breaking down harsh compounds and unlocking the deep, complex flavors hidden within.</p>
                            </div>
                        </div>
                        <div class="craft__step-card reveal">
                            <span class="craft__step-num">03</span>
                            <div class="craft__step-content">
                                <h4>Hand-Rolling</h4>
                                <p>Each cigar is rolled by artisans with over 15 years of experience. A single Wismilak Premium requires 187 precise hand-movements to complete.</p>
                            </div>
                        </div>
                        <div class="craft__step-card reveal">
                            <span class="craft__step-num">04</span>
                            <div class="craft__step-content">
                                <h4>Aging</h4>
                                <p>Finished cigars rest in cedar-lined rooms for a minimum of two years. This patient aging allows the wrapper, binder, and filler to marry into a unified masterpiece.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── CHRONICLES (VERTICAL EDITORIAL TIMELINE) ── --}}
        <section class="timeline-section" id="chronicles">
            <div class="timeline__track"></div>
            
            <div class="timeline__container">
                <!-- 1962 Node -->
                <div class="timeline__row">
                    <div class="timeline__node"></div>
                    <div class="timeline__content reveal">
                        <div class="timeline__year">1962</div>
                        <h4 class="timeline__title">The Foundation</h4>
                        <p class="timeline__desc">
                            Established in Surabaya, the journey began with a vision to master the intricate balance of
                            Indonesian tobacco and artisanal craftsmanship.
                        </p>
                    </div>
                    <div class="timeline__visual reveal">
                        <div class="timeline__image-frame">
                            <img src="{{ asset('images/1962.jpg') }}" alt="Wismilak Foundation 1962">
                        </div>
                    </div>
                </div>

                <!-- 1989 Node -->
                <div class="timeline__row">
                    <div class="timeline__node"></div>
                    <div class="timeline__content reveal">
                        <div class="timeline__year">1989</div>
                        <h4 class="timeline__title">Diplomat Era</h4>
                        <p class="timeline__desc">
                            The birth of an icon. Redefining excellence with a signature smooth blend that became a hallmark of
                            sophisticated smokers.
                        </p>
                    </div>
                    <div class="timeline__visual reveal">
                        <div class="timeline__image-frame">
                            <img src="{{ asset('images/1967.jpg') }}" alt="Wismilak Diplomat 1989">
                        </div>
                    </div>
                </div>

                <!-- 1999 Node -->
                <div class="timeline__row">
                    <div class="timeline__node"></div>
                    <div class="timeline__content reveal">
                        <div class="timeline__year">1999</div>
                        <h4 class="timeline__title">Mastery</h4>
                        <p class="timeline__desc">
                            Bringing traditional hand-rolling techniques to the forefront of luxury tobacco, setting new
                            standards for the archipelago.
                        </p>
                    </div>
                    <div class="timeline__visual reveal">
                        <div class="timeline__image-frame">
                            <img src="{{ asset('images/1999.jpg') }}" alt="Wismilak Mastery 1999">
                        </div>
                    </div>
                </div>

                <!-- 2012 Node -->
                <div class="timeline__row">
                    <div class="timeline__node"></div>
                    <div class="timeline__content reveal">
                        <div class="timeline__year">2012</div>
                        <h4 class="timeline__title">Legacy</h4>
                        <p class="timeline__desc">
                            Cementing our national legacy and expanding our horizons as a leading luxury brand on the global stage.
                        </p>
                    </div>
                    <div class="timeline__visual reveal">
                        <div class="timeline__image-frame">
                            <img src="{{ asset('images/2012.jpg') }}" alt="Wismilak Legacy 2012">
                        </div>
                    </div>
                </div>

                <!-- 2024 Node -->
                <div class="timeline__row">
                    <div class="timeline__node"></div>
                    <div class="timeline__content reveal">
                        <div class="timeline__year">2024</div>
                        <h4 class="timeline__title">Digital</h4>
                        <p class="timeline__desc">
                            Blending sixty years of tradition with modern innovation, creating curated digital experiences for the next generation.
                        </p>
                    </div>
                    <div class="timeline__visual reveal">
                        <div class="timeline__image-frame">
                            <img src="{{ asset('images/2024.jpg') }}" alt="Wismilak Digital 2024">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── OUR VALUES ── --}}
        <section class="values-section">
            <div class="max-w-editorial">
                <div class="timeline-header">
                    <span class="editorial-label reveal-text">Our Principles</span>
                    <h2 class="editorial-title reveal-text">The Values We <em>Uphold</em></h2>
                </div>
                <div class="values-grid">
                    <div class="value-card reveal-text">
                        <div class="value-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h4>Authenticity</h4>
                        <p>We never compromise on origin. Every leaf is traceable to its field, every process to its
                            artisan.
                            What you hold is genuine Indonesian heritage.</p>
                    </div>
                    <div class="value-card reveal-text">
                        <div class="value-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 6v6l4 2"></path>
                            </svg>
                        </div>
                        <h4>Patience</h4>
                        <p>Great cigars cannot be rushed. From the two-year aging process to the seasonal harvest cycle, we
                            honour the rhythm of nature and time.</p>
                    </div>
                    <div class="value-card reveal-text">
                        <div class="value-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                                </path>
                            </svg>
                        </div>
                        <h4>Devotion</h4>
                        <p>Over 5,000 artisans pour their mastery into every cigar. Their families and communities are the
                            living heartbeat of Wismilak's enduring legacy.</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="section-divider"></div>

        {{-- ── GRHA WISMILAK ── --}}
        <section class="editorial-section">
            <div class="max-w-editorial">
                <div class="editorial-grid">
                    <div class="editorial-text">
                        <span class="editorial-label reveal-text">The Sanctuary</span>
                        <h2 class="editorial-title reveal-text">Grha Wismilak: <em>Monument of Legacy</em></h2>
                        <p class="editorial-body reveal-text">Housed in a majestic colonial heritage building in Surabaya,
                            our
                            headquarters—<strong>Grha Wismilak</strong>—is more than just an office. With its iconic
                            pentagon-shaped windows and stained-glass artistry, it stands as a physical manifestation of our
                            respect for history and architectural beauty.</p>
                        <br>
                        <p class="editorial-body reveal-text">Visiting the sanctuary is a journey back in time, where the
                            scent
                            of aged cedar meets the whispers of a century-old legacy.</p>
                    </div>

                    <div class="editorial-image img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/hero-wismilak.jpg') }}');">
                    </div>
                </div>
            </div>
        </section>
        {{-- ── FLAVOR PROFILE ── --}}
        <section class="flavor-section">
            <div class="max-w-editorial">
                <div class="flavor-layout">
                    <div>
                        <span class="editorial-label reveal-text">The Palette</span>
                        <h2 class="editorial-title reveal-text">A Connoisseur's <em>Sensory Map</em></h2>
                        <p class="editorial-body reveal-text" style="margin-bottom: 4rem;">Our master blenders work like
                            composers, layering notes of wood, spice, and earth to create a profile that is uniquely
                            Javanese.
                        </p>
                        <div class="flavor-bars">
                            <div class="flavor-bar-item reveal-text">
                                <div class="flavor-label"><strong>Cedar & Wood</strong><span>85%</span></div>
                                <div class="flavor-track">
                                    <div class="flavor-fill" data-width="85"></div>
                                </div>
                            </div>
                            <div class="flavor-bar-item reveal-text">
                                <div class="flavor-label"><strong>Earthy Spice</strong><span>65%</span></div>
                                <div class="flavor-track">
                                    <div class="flavor-fill" data-width="65"></div>
                                </div>
                            </div>
                            <div class="flavor-bar-item reveal-text">
                                <div class="flavor-label"><strong>Dark Cocoa</strong><span>45%</span></div>
                                <div class="flavor-track">
                                    <div class="flavor-fill" data-width="45"></div>
                                </div>
                            </div>
                            <div class="flavor-bar-item reveal-text">
                                <div class="flavor-label"><strong>Roasted Nut</strong><span>70%</span></div>
                                <div class="flavor-track">
                                    <div class="flavor-fill" data-width="70"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flavor-visual reveal-text" style="background-image: url('{{ asset('images/map.jpg') }}');">
                    </div>
                </div>
            </div>
        </section>

        {{-- ── PHILOSOPHY INTERLUDE ── --}}
        <section class="philosophy-interlude">
            <div class="max-w-editorial">
                <p class="philosophy-text reveal-text">
                    In the quietude of the aging room, time itself becomes an ingredient.
                    Here, patience is not merely a virtue — it is the <em>secret of mastery</em>.
                </p>
                <span class="philosophy-author reveal-text">— The Wismilak Philosophy</span>
            </div>
        </section>

        {{-- ── GALLERY MOMENTS ── --}}
        <section class="gallery-section">
            <div class="max-w-editorial">
                <div class="timeline-header">
                    <span class="editorial-label reveal-text">Visual Journey</span>
                    <h2 class="editorial-title reveal-text">Moments of <em>Excellence</em></h2>
                </div>

                <div class="gallery-grid">
                    <div class="gallery-item img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/gallery.jpg') }}');">
                    </div>

                    <div class="gallery-item img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/gallery2.jpg') }}');">
                    </div>

                    <div class="gallery-item img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/gallery3.jpg') }}');">
                    </div>

                    <div class="gallery-item img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/gallery4.jpg') }}');">
                    </div>

                    <div class="gallery-item img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/gallery5.jpg') }}');">
                    </div>

                    <div class="gallery-item img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/gallery6.jpg') }}');">
                    </div>
                </div>
            </div>
        </section>

        {{-- ── AWARDS & RECOGNITION ── --}}
        <section class="trust-section">
            <div class="max-w-editorial">
                <div class="timeline-header">
                    <span class="editorial-label reveal-text">Recognition</span>
                    <h2 class="editorial-title reveal-text">Milestones of <em>Trust</em></h2>
                </div>
                <div class="trust-grid">
                    <div class="trust-card reveal-text">
                        <span class="trust-number">ISO</span>
                        <h4 class="trust-title">Global Quality Standard</h4>
                        <p class="trust-desc">Unwavering excellence verified by international quality control and manufacturing standards.</p>
                    </div>
                    <div class="trust-card reveal-text">
                        <span class="trust-number">WIIM</span>
                        <h4 class="trust-title">Publicly Traded</h4>
                        <p class="trust-desc">Listed on the Indonesia Stock Exchange, reflecting robust corporate governance and transparency.</p>
                    </div>
                    <div class="trust-card reveal-text">
                        <span class="trust-number">60+</span>
                        <h4 class="trust-title">Years of Heritage</h4>
                        <p class="trust-desc">Passing down artisanal tobacco knowledge and Javanese craftsmanship since 1962.</p>
                    </div>
                    <div class="trust-card reveal-text">
                        <span class="trust-number">34</span>
                        <h4 class="trust-title">Provinces Reached</h4>
                        <p class="trust-desc">A nation-wide footprint of premium cigars, uniting connoisseurs across the entire Indonesian archipelago.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── PRODUCT SHOWCASE ── --}}
        <section class="showcase-section">
            <div class="max-w-editorial">
                <div class="timeline-header">
                    <span class="editorial-label reveal-text">The Collection</span>
                    <h2 class="editorial-title reveal-text">Signature <em>Selections</em></h2>
                </div>

                <div class="showcase-grid">
                    <div class="showcase-card reveal-text">
                        <div class="showcase-image img-placeholder"
                            style="background-image: url('{{ asset('images/corona.png') }}');">
                        </div>

                        <div class="showcase-info">
                            <h3>Premium Seleccion</h3>
                            <span class="showcase-tag">Hand-Rolled · Long Filler</span>
                            <p>The flagship. A full-bodied blend of Jember and Madura long-fillers, wrapped in silken Javano
                                leaf. Rich notes of cedar, dark chocolate, and roasted earth.</p>
                        </div>
                    </div>

                    <div class="showcase-card reveal-text">
                        <div class="showcase-image img-placeholder"
                            style="background-image: url('{{ asset('images/robusto.png') }}');">
                        </div>

                        <div class="showcase-info">
                            <h3>Diplomat</h3>
                            <span class="showcase-tag">Machine-Crafted · Signature Blend</span>
                            <p>The icon of everyday elegance. A perfectly balanced blend that has been the hallmark of
                                sophisticated Indonesian smokers for over three decades.</p>
                        </div>
                    </div>

                    <div class="showcase-card reveal-text">
                        <div class="showcase-image img-placeholder"
                            style="background-image: url('{{ asset('images/clasico.png') }}');">
                        </div>

                        <div class="showcase-info">
                            <h3>Galan</h3>
                            <span class="showcase-tag">Slim Format · Modern Classic</span>
                            <p>Sleek, refined, and contemporary. Galan offers a lighter profile with subtle floral
                                undertones,
                                crafted for the modern connoisseur on the move.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── THE RITUAL ── --}}
        <section class="ritual-section">
            <div class="max-w-editorial">
                <div class="timeline-header">
                    <span class="editorial-label reveal-text">The Connoisseur's Guide</span>
                    <h2 class="editorial-title reveal-text">The Art of the <em>Ritual</em></h2>
                </div>
                <div class="ritual-steps">
                    <div class="ritual-step reveal-text">
                        <div class="ritual-num">I</div>
                        <h4>Inspect</h4>
                        <p>Hold the cigar. Feel its weight and texture. A quality cigar should feel firm with slight give.
                        </p>
                    </div>
                    <div class="ritual-step reveal-text">
                        <div class="ritual-num">II</div>
                        <h4>Clip</h4>
                        <p>Make a clean cut just above the cap line. Precision here ensures a perfect, unrestricted draw.
                        </p>
                    </div>
                    <div class="ritual-step reveal-text">
                        <div class="ritual-num">III</div>
                        <h4>Toast</h4>
                        <p>Gently rotate the foot of the cigar above the flame. Do not inhale — let the foot ignite evenly.
                        </p>
                    </div>
                    <div class="ritual-step reveal-text">
                        <div class="ritual-num">IV</div>
                        <h4>Draw</h4>
                        <p>Take slow, deliberate puffs. Let the smoke rest on your palate. Discover cedar, earth, and spice.
                        </p>
                    </div>
                    <div class="ritual-step reveal-text">
                        <div class="ritual-num">V</div>
                        <h4>Savour</h4>
                        <p>A cigar is a conversation with time. Let it rest between draws. The flavour evolves as you
                            journey.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        {{-- ── MASTER BLENDER ── --}}
        <section class="blender-section">
            <div class="max-w-editorial">
                <div class="blender-grid">
                    <div class="blender-image img-placeholder reveal-text"
                        style="background-image: url('{{ asset('images/story-tobacco.jpg') }}');">
                    </div>

                    <div class="blender-content">
                        <span class="editorial-label reveal-text">The Architect of Flavor</span>
                        <h2 class="editorial-title reveal-text">The Master <em>Blender</em></h2>
                        <p class="blender-quote reveal-text">
                            "A cigar is not assembled — it is composed. Each leaf has a voice, and my task is to arrange
                            them
                            into a symphony that speaks of Java, of patience, and of generations before me."
                        </p>
                        <h3 class="blender-name reveal-text">The Wismilak Master Blender</h3>
                        <span class="blender-role reveal-text">Head of Artisanal Blending · 30+ Years</span>
                    </div>
                </div>
            </div>
        </section>
        {{-- ── THE LOUNGE EXPERIENCE ── --}}
        <section class="lounge-section">
            <div class="max-w-editorial">
                <div class="lounge-grid">
                    <!-- Left Side Details -->
                    <div class="lounge-details">
                        <div class="lounge-header-wrap">
                            <span class="lounge-badge reveal-text">The Experience</span>
                            <h2 class="lounge-title reveal-text">The Wismilak <em>Lounge</em></h2>
                        </div>
                        <p class="lounge-intro reveal-text">
                            Step into a world where time slows down. Located inside our historic Surabaya sanctuary, the Wismilak Lounge is an intimate haven designed for the true connoisseur.
                        </p>
                        <ul class="lounge-amenities">
                            <li class="lounge-amenity-item reveal-text">
                                <div class="lounge-amenity-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                </div>
                                <div class="lounge-amenity-text">
                                    <strong>Spanish Cedar Humidor Room</strong>
                                    <span>Housing our rarest vintages and custom selections under absolute climate precision.</span>
                                </div>
                            </li>
                            <li class="lounge-amenity-item reveal-text">
                                <div class="lounge-amenity-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                </div>
                                <div class="lounge-amenity-text">
                                    <strong>Private Tasting Suites</strong>
                                    <span>Quiet, acoustically optimized chambers tailored for deep conversation and tasting rituals.</span>
                                </div>
                            </li>
                            <li class="lounge-amenity-item reveal-text">
                                <div class="lounge-amenity-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                </div>
                                <div class="lounge-amenity-text">
                                    <strong>Curated Coffee & Spirit Pairings</strong>
                                    <span>Pair your cigar with single-origin Javanese coffees or aged single malts selected by our sommelier.</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Right Side Media Visual Frame -->
                    <div class="reveal-text">
                        <div class="lounge-visual-frame">
                            <img src="{{ asset('images/wismilak-lounge.jpg') }}" alt="Wismilak Heritage Cigar Lounge">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- ── PRESS QUOTES ── --}}
        <section class="press-section">
            <div class="max-w-editorial">
                <div class="timeline-header">
                    <span class="editorial-label reveal-text">What They Say</span>
                    <h2 class="editorial-title reveal-text">Words of <em>Distinction</em></h2>
                </div>
                <div class="press-grid">
                    <div class="press-card reveal-text">
                        <p class="press-quote">"Wismilak represents the pinnacle of Indonesian tobacco artistry — a brand
                            that
                            treats every cigar as a work of art."</p>
                        <span class="press-source">Tobacco Heritage Review</span>
                    </div>
                    <div class="press-card reveal-text">
                        <p class="press-quote">"In a world of mass production, Wismilak stands alone as a keeper of
                            traditional
                            hand-rolling mastery and volcanic terroir."</p>
                        <span class="press-source">Asia Luxury Journal</span>
                    </div>
                    <div class="press-card reveal-text">
                        <p class="press-quote">"The aging process alone sets Wismilak apart. Two years in cedar — that is
                            not
                            business, that is devotion."</p>
                        <span class="press-source">Connoisseur's Digest</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── FAQ ── --}}
        <section class="faq-new-section">
            <div class="max-w-editorial">
                <div class="faq-split-grid">
                    <!-- Left Side Header -->
                    <div class="faq-sticky-side reveal-text">
                        <span class="faq-label">For the Curious</span>
                        <h2 class="faq-title">The Connoisseur's <br><em>Questions</em></h2>
                        <p class="faq-subtitle">Explore answers to common inquiries regarding our heritage, cigar aging processes, and custom selections.</p>
                    </div>

                    <!-- Right Side Accordion List -->
                    <div class="faq-new-list">
                        <div class="faq-new-item reveal-text">
                            <button class="faq-new-trigger">
                                <span>What makes Wismilak different from other Indonesian brands?</span>
                                <span class="faq-icon-arrow">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="m6 9 6 6 6-6"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-new-answer">
                                <div class="faq-new-answer-content">
                                    Every Wismilak Premium cigar uses only hand-selected long-filler tobacco from the volcanic highlands of East Java, aged for a minimum of two years in custom Spanish cedar rooms. This commitment to patience over speed sets us apart.
                                </div>
                            </div>
                        </div>

                        <div class="faq-new-item reveal-text">
                            <button class="faq-new-trigger">
                                <span>How should I store my premium cigars?</span>
                                <span class="faq-icon-arrow">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="m6 9 6 6 6-6"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-new-answer">
                                <div class="faq-new-answer-content">
                                    Premium cigars should be stored inside a dedicated cedar humidor at 65% to 72% relative humidity and a constant temperature between 18°C and 21°C. This protects natural leaf oils and preserves the delicate flavor profile over time.
                                </div>
                            </div>
                        </div>

                        <div class="faq-new-item reveal-text">
                            <button class="faq-new-trigger">
                                <span>Can I request a private visit to the Wismilak workshop?</span>
                                <span class="faq-icon-arrow">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="m6 9 6 6 6-6"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-new-answer">
                                <div class="faq-new-answer-content">
                                    Yes. We host private, pre-arranged tours of the historic Grha Wismilak sanctuary in Surabaya. Guests can witness our artisans rolling cigars, explore the cedar aging chambers, and enjoy an exclusive sommelier-guided tasting session.
                                </div>
                            </div>
                        </div>

                        <div class="faq-new-item reveal-text">
                            <button class="faq-new-trigger">
                                <span>What is the recommended pairing for a Wismilak Premium?</span>
                                <span class="faq-icon-arrow">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="m6 9 6 6 6-6"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-new-answer">
                                <div class="faq-new-answer-content">
                                    Our master blenders recommend pairing our robusto and corona selections with rich, complex flavors, such as single-origin Javanese dark roast coffee, aged single-malt whiskies, or 70%+ dark artisanal chocolate.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ── CLOSING SECTION ── --}}
        <section class="closing-section">
            <div class="max-w-editorial">
                <blockquote class="closing-quote reveal-text">
                    "Every leaf tells the story of Java's volcanic soil, nurtured by generations who understand that true
                    quality begins where <em>nature and devotion</em> converge."
                </blockquote>
                <div class="reveal-text" style="margin-top: 4rem;">
                    <a href="{{ route('product.index') }}" class="hero-cta">Explore the Collection</a>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.registerPlugin(ScrollTrigger);

            // Reveal animations
            const reveals = document.querySelectorAll('.reveal-text');
            reveals.forEach((el) => {
                gsap.fromTo(el,
                    { opacity: 0, y: 50 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 1.5,
                        ease: "power4.out",
                        scrollTrigger: {
                            trigger: el,
                            start: "top 90%",
                            toggleActions: "play none none none"
                        }
                    }
                );
            });


            // Hero parallax
            gsap.to(".hero-bg", {
                yPercent: 30,
                ease: "none",
                scrollTrigger: {
                    trigger: ".hero-cinematic",
                    start: "top top",
                    end: "bottom top",
                    scrub: true
                }
            });

            // Timeline scroll
            // Extreme Terroir Parallax
            gsap.to(".terroir-bg-extreme", {
                y: -100,
                ease: "none",
                scrollTrigger: {
                    trigger: ".terroir-section",
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true
                }
            });

            gsap.to(".terroir-card-float", {
                y: (i, target) => i % 2 === 0 ? -50 : 50,
                ease: "none",
                scrollTrigger: {
                    trigger: ".terroir-section",
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true
                }
            });


            // Flavor bar fill animation
            document.querySelectorAll('.flavor-fill').forEach(bar => {
                const w = bar.getAttribute('data-width');
                ScrollTrigger.create({
                    trigger: bar,
                    start: "top 90%",
                    onEnter: () => { bar.style.width = w + '%'; }
                });
            });

            // Stagger animations for grids
            document.querySelectorAll('.craft-grid, .values-grid, .awards-grid, .gallery-grid').forEach(grid => {
                const items = grid.children;
                gsap.fromTo(items,
                    { opacity: 0, y: 40 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 1,
                        stagger: 0.15,
                        ease: "power3.out",
                        scrollTrigger: {
                            trigger: grid,
                            start: "top 85%"
                        }
                    }
                );
            });
            // FAQ Toggle
            document.querySelectorAll('.faq-new-trigger').forEach((question) => {
                question.addEventListener('click', () => {
                    const faqItem = question.closest('.faq-new-item');
                    const answer = faqItem.querySelector('.faq-new-answer');

                    // tutup FAQ lain
                    document.querySelectorAll('.faq-new-item').forEach((item) => {
                        if (item !== faqItem) {
                            item.classList.remove('active');
                            item.querySelector('.faq-new-answer').style.maxHeight = null;
                        }
                    });

                    // buka/tutup FAQ yang diklik
                    faqItem.classList.toggle('active');

                    if (faqItem.classList.contains('active')) {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                    } else {
                        answer.style.maxHeight = null;
                    }
                });
            });
        });
    </script>
@endpush