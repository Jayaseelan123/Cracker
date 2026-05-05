@extends('layouts.front')

@section('title', 'Blog - Crackers Time')
@section('hero_title', 'Our Blog')
@section('hero_subtitle', 'Tips, Guides & Stories About Crackers & Celebrations')

@section('content')
<style>
.blog-badge{display:inline-block;background:linear-gradient(135deg,#ff9900,#ff6600);color:#fff;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;padding:4px 14px;border-radius:30px;margin-bottom:12px}
.blog-card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 6px 25px rgba(0,0,0,.07);margin-bottom:30px;transition:transform .3s,box-shadow .3s}
.blog-card:hover{transform:translateY(-5px);box-shadow:0 14px 35px rgba(0,0,0,.12)}
.blog-card-img{width:100%;height:220px;object-fit:cover}
.blog-card-body{padding:24px}
.blog-meta{font-size:.82rem;color:#999;margin-bottom:8px}
.blog-meta span{margin-right:14px}
.blog-card-body h3{font-size:1.15rem;font-weight:800;color:#1a1a2e;margin-bottom:10px;line-height:1.4}
.blog-card-body p{color:#666;font-size:.9rem;line-height:1.75;margin-bottom:14px}
.read-more{color:#ff6600;font-weight:700;font-size:.88rem;text-decoration:none;display:inline-flex;align-items:center;gap:6px}
.read-more:hover{color:#cc4400}
/* Full Article */
.article-section{background:#fff;border-radius:16px;padding:36px;box-shadow:0 6px 25px rgba(0,0,0,.07);margin-bottom:30px}
.article-section h2{font-size:1.4rem;font-weight:800;color:#1a1a2e;margin-bottom:6px}
.article-section h4{font-size:1.05rem;font-weight:700;color:#1a1a2e;margin:20px 0 8px}
.article-section p{color:#555;line-height:1.85;font-size:.95rem}
.article-section ul li{color:#555;line-height:1.85;font-size:.95rem;margin-bottom:6px}
.tip-box{background:linear-gradient(135deg,#fff8e1,#fffde7);border-left:4px solid #ff9900;border-radius:8px;padding:16px 20px;margin:18px 0}
.tip-box p{margin:0;color:#555;font-size:.9rem}
/* Sidebar */
.sidebar-card{background:#fff;border-radius:14px;padding:24px;box-shadow:0 4px 18px rgba(0,0,0,.07);margin-bottom:24px}
.sidebar-card h5{font-size:1rem;font-weight:700;color:#1a1a2e;margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid #ff9900}
.sidebar-post{display:flex;gap:12px;margin-bottom:14px;align-items:flex-start}
.sidebar-post .sp-num{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ff9900,#ff6600);color:#fff;font-weight:700;font-size:.85rem;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sidebar-post p{margin:0;font-size:.85rem;font-weight:600;color:#333;line-height:1.4}
.sidebar-post small{color:#999;font-size:.78rem}
.cat-chip{display:inline-block;background:#f0f4ff;color:#333;border-radius:20px;padding:6px 14px;font-size:.82rem;margin:4px;text-decoration:none;transition:background .2s}
.cat-chip:hover{background:#ff9900;color:#fff}
.newsletter-box{background:linear-gradient(135deg,#1a1a2e,#16213e);border-radius:14px;padding:28px;text-align:center;color:#fff}
.newsletter-box h5{font-weight:700;margin-bottom:8px}
.newsletter-box p{font-size:.85rem;opacity:.8;margin-bottom:16px}
.newsletter-box input{width:100%;padding:10px 14px;border-radius:8px;border:none;font-size:.9rem;margin-bottom:10px}
.newsletter-box button{width:100%;padding:10px;background:linear-gradient(135deg,#ff9900,#ff6600);border:none;border-radius:8px;color:#fff;font-weight:700;cursor:pointer}
/* Animate */
.animate{opacity:0;transform:translateY(30px);transition:opacity .7s ease,transform .7s ease}
.animate.show{opacity:1;transform:translateY(0)}
.d1{transition-delay:.1s}.d2{transition-delay:.2s}.d3{transition-delay:.3s}
</style>

<div class="row g-4">

    <!-- ═══ LEFT: ARTICLES ═══ -->
    <div class="col-lg-8">

        <!-- POST 1 -->
        <div class="article-section animate d1" id="science-behind-the-sparkle">
            <span class="blog-badge">Science</span>
            <div class="blog-meta">
                <span><i class="fas fa-calendar-alt"></i> Aug 23, 2025</span>
                <span><i class="fas fa-eye"></i> 629 views</span>
                <span><i class="fas fa-tag"></i> Firecrackers</span>
            </div>
            <h2>The Science Behind the Sparkle: How Firecrackers Create Light, Sound & Color</h2>
            <p>Ever stared in wonder at a fireworks display and asked — how does that happen? There's incredible chemistry and physics packed into every cracker. Let's uncover the magic!</p>
            <h4>🔥 The Chemical Reaction</h4>
            <p>At the heart of every firecracker is a carefully blended mixture of an oxidiser (like potassium nitrate), a fuel (like charcoal or sulphur), and a binder. When ignited, the oxidiser releases oxygen rapidly, allowing the fuel to burn intensely — releasing heat, light, and gas at incredible speed.</p>
            <h4>🌈 How Colors Are Made</h4>
            <p>Different metal salts burn at different wavelengths of visible light — this is called "flame emission." Specific colours come from:</p>
            <ul>
                <li><strong>Red</strong> — Strontium salts</li>
                <li><strong>Green</strong> — Barium salts</li>
                <li><strong>Blue</strong> — Copper salts</li>
                <li><strong>Yellow/Orange</strong> — Sodium salts</li>
                <li><strong>White/Silver</strong> — Magnesium or Aluminium powder</li>
            </ul>
            <h4>💥 The Sound — Where Does It Come From?</h4>
            <p>The loud bang from a cracker is caused by a rapid pressure wave — essentially a miniature explosion that compresses and displaces air faster than the speed of sound, creating a shockwave we hear as a boom.</p>
            <div class="tip-box"><p>💡 <strong>Fun Fact:</strong> The study of fireworks chemistry is called "pyrotechnics" — from the Greek words for fire (pyr) and art (technē).</p></div>
            <h4>✨ Sparklers & Their Physics</h4>
            <p>Sparklers burn at around 1,000–1,600°C but feel "safe" because the tiny burning metal particles cool quickly before reaching your skin. They typically use iron, steel, or aluminium powder as the fuel source.</p>
        </div>

        <!-- POST 2 -->
        <div class="article-section animate d2" id="eco-friendly-crackers-2025">
            <span class="blog-badge">Eco</span>
            <div class="blog-meta">
                <span><i class="fas fa-calendar-alt"></i> Aug 21, 2025</span>
                <span><i class="fas fa-eye"></i> 842 views</span>
                <span><i class="fas fa-tag"></i> Green Diwali</span>
            </div>
            <h2>Top 10 Eco-Friendly Crackers for a Green Diwali 2025</h2>
            <p>Diwali is the Festival of Lights — and we can celebrate brilliantly while protecting our planet. Here are the top 10 eco-friendly crackers approved by CSIR-NEERI that you can buy online safely.</p>
            <h4>🌿 What Are Green Crackers?</h4>
            <p>Green crackers are firecrackers developed by the Council of Scientific and Industrial Research (CSIR) and the National Environmental Engineering Research Institute (NEERI). They produce 30–40% less particulate emissions and use water as a dust suppressant.</p>
            <h4>🏆 Top 10 Picks for 2025</h4>
            <ul>
                <li><strong>1. SWAS (Safe Water Sprinkler)</strong> — Emits water vapour, near-zero smoke</li>
                <li><strong>2. STAR (Safe Thermite Cracker)</strong> — Vibrant colours with minimal ash</li>
                <li><strong>3. SAFAL (Safe Minimal Aluminium)</strong> — Replaces aluminium with less-polluting alternatives</li>
                <li><strong>4. Eco Sparklers</strong> — Steel powder sparklers, biodegradable sticks</li>
                <li><strong>5. Green Flower Pots</strong> — Traditional effect with 40% fewer emissions</li>
                <li><strong>6. Anar (Fountain) Eco</strong> — Beautiful golden fountain, low sulphur</li>
                <li><strong>7. Ground Spinner Eco</strong> — Spinning wheel with reduced smoke</li>
                <li><strong>8. Green Chakkars</strong> — Colourful spinning crackers, minimal noise</li>
                <li><strong>9. Sky Shot Eco</strong> — Aerial cracker with 35% lower PM2.5</li>
                <li><strong>10. Bijli Eco</strong> — Classic cracker sound, minimal chemicals</li>
            </ul>
            <div class="tip-box"><p>🌿 <strong>Tip:</strong> All CSIR-NEERI approved crackers carry a QR code on the packaging. Always scan to verify authenticity before purchase.</p></div>
            <h4>🛒 Buy Green Crackers at Crackers Time</h4>
            <p>We stock a fully verified range of CSIR-NEERI green crackers. All products are factory-sealed, licensed, and available for pan-India delivery. Celebrate brightly — breathe easily!</p>
        </div>

        <!-- POST 3 -->
        <div class="article-section animate d3" id="cracker-safety-guide">
            <span class="blog-badge">Safety</span>
            <div class="blog-meta">
                <span><i class="fas fa-calendar-alt"></i> Aug 21, 2025</span>
                <span><i class="fas fa-eye"></i> 855 views</span>
                <span><i class="fas fa-tag"></i> Family Safety</span>
            </div>
            <h2>Ultimate Guide to Cracker Safety: Essential Tips for Family Celebrations</h2>
            <p>Firecrackers are joy — but only when handled safely. Follow this complete guide to ensure every member of your family enjoys Diwali without any accidents.</p>
            <h4>🧯 Before You Start</h4>
            <ul>
                <li>Always buy crackers from licensed, reputable shops — never from roadside vendors</li>
                <li>Read the instructions on every pack before use</li>
                <li>Keep a bucket of water and a sand bucket nearby at all times</li>
                <li>Wear cotton clothes — synthetic fabrics are highly flammable</li>
                <li>Never burst crackers indoors, in closed spaces, or near vehicles</li>
            </ul>
            <h4>👶 Safety for Children</h4>
            <ul>
                <li>Children under 15 should only handle sparklers — under adult supervision</li>
                <li>Keep younger children at least 5 metres away from burst crackers</li>
                <li>Never allow children to hold a lit cracker in their hands except sparklers</li>
                <li>Ensure children wear slippers/shoes — not barefoot</li>
            </ul>
            <h4>🔥 During Bursting</h4>
            <ul>
                <li>Light crackers one at a time — never a bundle together</li>
                <li>Use a long agarbatti (incense stick) to light crackers — not a matchstick held close</li>
                <li>After lighting, move away quickly to a safe distance</li>
                <li>Never bend over a cracker to re-light a dud — wait 15 minutes and douse with water</li>
            </ul>
            <div class="tip-box"><p>🚨 <strong>Emergency:</strong> In case of a burn, immediately cool with running water for 10–15 minutes. Do NOT apply toothpaste, oil, or ice. Seek medical help for severe burns.</p></div>
            <h4>🐾 Protecting Pets</h4>
            <p>Animals have hearing that's far more sensitive than humans. Keep pets indoors during crackers, play calming music, close windows and curtains, and consult your vet about anxiety medication if needed. Never set off crackers near stray animals.</p>
        </div>

        <!-- POST 4 -->
        <div class="article-section animate" id="history-of-firecrackers">
            <span class="blog-badge">History</span>
            <div class="blog-meta">
                <span><i class="fas fa-calendar-alt"></i> Aug 21, 2025</span>
                <span><i class="fas fa-eye"></i> 498 views</span>
                <span><i class="fas fa-tag"></i> Heritage</span>
            </div>
            <h2>The Brilliant History of Firecrackers: From Ancient China to Your Diwali</h2>
            <p>Firecrackers have a fascinating 2,000-year history that spans continents, cultures, and centuries. Here's the story of how they became central to India's most beloved festival.</p>
            <h4>🇨🇳 The Accidental Invention (200 BC — China)</h4>
            <p>The story begins in China around 200 BC. Legend says a cook accidentally mixed charcoal, sulphur, and potassium nitrate — three common kitchen ingredients — and discovered gunpowder. When packed into bamboo tubes and thrown into fire, it produced a loud bang believed to ward off evil spirits.</p>
            <h4>🌍 Spreading Across the World (9th–13th Century)</h4>
            <p>Gunpowder knowledge travelled via the Silk Road to the Arab world, then to Europe. By the 13th century, European alchemists had formulated refined versions of gunpowder. The first true "fireworks" as an art form emerged in Italy during the Renaissance period.</p>
            <h4>🇮🇳 Firecrackers Come to India</h4>
            <p>Firecrackers reached India through trade routes and were quickly woven into religious and cultural festivities. The city of Sivakasi in Tamil Nadu — now called the "Fireworks Capital of India" — became the manufacturing hub in the 1920s when the Shanmughanaar family started the industry after learning firework-making techniques from Kolkata traders.</p>
            <h4>🪔 Firecrackers & Diwali</h4>
            <p>Diwali originally celebrated the return of Lord Rama to Ayodhya — people lit oil lamps (diyas) to guide his way. Over centuries, firecrackers were added to the celebration as a symbol of joy, the victory of light over darkness, and the warding away of evil — a tradition that continues to this day.</p>
        </div>

        <!-- POST 5 -->
        <div class="article-section animate" id="kid-friendly-crackers-2025">
            <span class="blog-badge">Kids</span>
            <div class="blog-meta">
                <span><i class="fas fa-calendar-alt"></i> Aug 21, 2025</span>
                <span><i class="fas fa-eye"></i> 684 views</span>
                <span><i class="fas fa-tag"></i> Family Fun</span>
            </div>
            <h2>10 Safe & Sparkling Crackers for Kids — 2025 Guide</h2>
            <p>Want to make Diwali magical for your little ones without worrying about safety? Here are the top 10 kid-friendly crackers that sparkle beautifully with minimal risk.</p>
            <ul>
                <li><strong>1. Sparklers (Phooljari)</strong> — The classic! Safe under adult supervision, produce brilliant golden sparks</li>
                <li><strong>2. Snake Tablets</strong> — No sound, no sparks — just a fascinating growing snake of ash. Perfect for tiny tots</li>
                <li><strong>3. Flower Pots (Anar)</strong> — Placed on the ground, shoots colourful sparks upward — safe distance, big wow factor</li>
                <li><strong>4. Ground Spinner (Chakkar)</strong> — Spins on the ground with coloured sparks — thrilling to watch from a safe distance</li>
                <li><strong>5. Colour Smoke Bombs</strong> — Emit coloured smoke, no sparks or fire — great for photos!</li>
                <li><strong>6. Paper Caps (Caps for Toy Guns)</strong> — Tiny sound, zero risk — perfect for toddlers with toy cap guns</li>
                <li><strong>7. Strawberry / Lemon Bombs</strong> — Small, colourful, mild pop — suitable for older children (8+) under supervision</li>
                <li><strong>8. Moon Traveller</strong> — Ground-based rocket that spins and shoots colour — very visual, moderate distance needed</li>
                <li><strong>9. Butterfly</strong> — Spins and flies upward briefly with beautiful light trails — exciting and relatively gentle</li>
                <li><strong>10. Twinkling Stars</strong> — Small stars that pop and glitter on the ground — safe, colourful, and fun</li>
            </ul>
            <div class="tip-box"><p>👨‍👩‍👧 <strong>Rule:</strong> Children below 15 years should ALWAYS have an adult present. Never leave children unsupervised with any crackers — even sparklers reach 1,000°C!</p></div>
        </div>

        <!-- POST 6 -->
        <div class="article-section animate" id="budget-for-diwali-crackers-2025">
            <span class="blog-badge">Budget Tips</span>
            <div class="blog-meta">
                <span><i class="fas fa-calendar-alt"></i> Aug 21, 2025</span>
                <span><i class="fas fa-eye"></i> 456 views</span>
                <span><i class="fas fa-tag"></i> Smart Shopping</span>
            </div>
            <h2>How to Budget for Diwali Crackers: Celebrate More, Spend Less in 2025</h2>
            <p>Diwali doesn't have to burn a hole in your pocket! With smart planning and the right choices, you can have a spectacular celebration on any budget.</p>
            <h4>📋 Step 1 — Set a Clear Budget</h4>
            <p>Before you start shopping, decide your total cracker budget. Financial experts recommend spending no more than 5–10% of your monthly income on Diwali crackers. Write it down and stick to it!</p>
            <h4>🛒 Step 2 — Buy Online for Better Prices</h4>
            <p>Online stores like Crackers Time offer factory-direct pricing — cutting out the middlemen. You'll typically save 15–30% compared to local market prices, plus get free doorstep delivery.</p>
            <h4>🎁 Step 3 — Choose Combo Packs</h4>
            <p>Combo packs and assorted boxes give you more variety at a lower per-piece cost. Our Family Diwali Pack and Grand Celebration Box are perennial bestsellers that offer great value.</p>
            <h4>⏰ Step 4 — Buy Early</h4>
            <p>Prices spike closer to Diwali as demand surges. Ordering 3–4 weeks in advance saves you 10–20% and ensures stock availability for your preferred products.</p>
            <h4>✅ Step 5 — Prioritise Variety Over Quantity</h4>
            <p>A mix of sparklers, a few flower pots, one or two aerial shots, and some colour smoke bombs will create more "wow" moments than a large pile of the same product. Quality over quantity every time!</p>
            <div class="tip-box"><p>💰 <strong>Pro Tip:</strong> Pool resources with neighbours or family members for a joint purchase — you'll unlock bulk discounts and everyone gets more bang for their buck!</p></div>
        </div>

    </div><!-- /col-lg-8 -->

    <!-- ═══ RIGHT: SIDEBAR ═══ -->
    <div class="col-lg-4">

        <!-- Popular Posts -->
        <div class="sidebar-card animate d1">
            <h5>🔥 Popular Posts</h5>
            @foreach($posts as $i => $p)
            <div class="sidebar-post">
                <div class="sp-num">{{ $i + 1 }}</div>
                <div>
                    <p><a href="#{{ $p['slug'] }}" style="color:#1a1a2e;text-decoration:none;">{{ $p['title'] }}</a></p>
                    <small><i class="fas fa-eye"></i> {{ $p['views'] }} views &nbsp; {{ $p['date'] }}</small>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Categories -->
        <div class="sidebar-card animate d2">
            <h5>📂 Categories</h5>
            <a class="cat-chip" href="#science-behind-the-sparkle">Science</a>
            <a class="cat-chip" href="#eco-friendly-crackers-2025">Eco / Green</a>
            <a class="cat-chip" href="#cracker-safety-guide">Safety</a>
            <a class="cat-chip" href="#history-of-firecrackers">History</a>
            <a class="cat-chip" href="#kid-friendly-crackers-2025">Kids</a>
            <a class="cat-chip" href="#budget-for-diwali-crackers-2025">Budget Tips</a>
        </div>

        <!-- Shop CTA -->
        <div class="sidebar-card animate d3" style="background:linear-gradient(135deg,#ff9900,#ff6600);color:#fff;text-align:center;">
            <div style="font-size:48px;margin-bottom:10px;">🎆</div>
            <h5 style="color:#fff;font-size:1.1rem;">Ready to Celebrate?</h5>
            <p style="font-size:.88rem;opacity:.9;margin-bottom:16px;">Shop premium crackers at the best prices — delivered to your doorstep!</p>
            <a href="{{ route('home') }}" class="btn btn-light fw-bold rounded-pill px-4" style="color:#ff6600;">🛒 Shop Now</a>
        </div>

        <!-- Newsletter -->
        <div class="newsletter-box animate">
            <div style="font-size:36px;margin-bottom:10px;">📬</div>
            <h5>Stay Updated!</h5>
            <p>Get the latest cracker tips, Diwali guides, and exclusive offers in your inbox.</p>
            <input type="email" placeholder="Your email address">
            <button type="button" onclick="this.textContent='✅ Subscribed!';this.disabled=true">Subscribe Now</button>
        </div>

        <!-- Quick Tips -->
        <div class="sidebar-card animate" style="margin-top:24px;">
            <h5>💡 Quick Safety Tips</h5>
            <ul style="padding-left:18px;margin:0;">
                <li style="font-size:.88rem;color:#555;margin-bottom:8px;">Always buy from licensed sellers</li>
                <li style="font-size:.88rem;color:#555;margin-bottom:8px;">Keep water bucket nearby</li>
                <li style="font-size:.88rem;color:#555;margin-bottom:8px;">Wear cotton clothes</li>
                <li style="font-size:.88rem;color:#555;margin-bottom:8px;">Never re-light a dud cracker</li>
                <li style="font-size:.88rem;color:#555;margin-bottom:8px;">Keep pets indoors</li>
                <li style="font-size:.88rem;color:#555;">Supervise children at all times</li>
            </ul>
        </div>

    </div><!-- /col-lg-4 -->

</div><!-- /row -->

<script>
document.addEventListener("DOMContentLoaded", () => {
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting) e.target.classList.add("show"); });
    }, { threshold: 0.1 });
    document.querySelectorAll(".animate").forEach(el => obs.observe(el));
});
</script>
@endsection
