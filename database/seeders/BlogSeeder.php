<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'The Science Behind the Sparkle: How Firecrackers Create Light, Sound & Color',
                'slug' => 'science-behind-sparkle',
                'category' => 'Science',
                'excerpt' => 'Ever stared in wonder at a fireworks display? Discover the incredible chemistry and physics packed into every cracker.',
                'content' => '<h2>The Science Behind the Sparkle: How Firecrackers Create Light, Sound & Color</h2>
<p>Ever stared in wonder at a fireworks display and asked — how does that happen? There\'s incredible chemistry and physics packed into every cracker. Let\'s uncover the magic!</p>
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
<h4>✨ Sparklers & Their Physics</h4>
<p>Sparklers burn at around 1,000–1,600°C but feel "safe" because the tiny burning metal particles cool quickly before reaching your skin.</p>',
                'views' => 429,
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Top 10 Eco-Friendly Crackers for a Green Diwali 2025',
                'slug' => 'eco-friendly-crackers-2025',
                'category' => 'Eco',
                'excerpt' => 'Celebrate Diwali brilliantly while protecting our planet with these top 10 eco-friendly crackers.',
                'content' => '<h2>Top 10 Eco-Friendly Crackers for a Green Diwali 2025</h2>
<p>Diwali is the Festival of Lights — and we can celebrate brilliantly while protecting our planet.</p>
<h4>🌿 What Are Green Crackers?</h4>
<p>Green crackers are firecrackers developed by CSIR-NEERI. They produce 30–40% less particulate emissions and use water as a dust suppressant.</p>
<h4>🏆 Top 10 Picks for 2025</h4>
<ul>
<li><strong>1. SWAS (Safe Water Sprinkler)</strong> — Emits water vapour, near-zero smoke</li>
<li><strong>2. STAR (Safe Thermite Cracker)</strong> — Vibrant colours with minimal ash</li>
<li><strong>3. SAFAL (Safe Minimal Aluminium)</strong> — Less-polluting alternatives</li>
<li><strong>4. Eco Sparklers</strong> — Steel powder sparklers, biodegradable sticks</li>
<li><strong>5. Green Flower Pots</strong> — Traditional effect with 40% fewer emissions</li>
</ul>',
                'views' => 342,
                'is_published' => true,
                'published_at' => now()->subDays(25),
            ],
            [
                'title' => 'Ultimate Guide to Cracker Safety: Essential Tips for Family Celebrations',
                'slug' => 'cracker-safety-guide',
                'category' => 'Safety',
                'excerpt' => 'Firecrackers are joy — but only when handled safely. Follow this complete guide for a safe celebration.',
                'content' => '<h2>Ultimate Guide to Cracker Safety: Essential Tips for Family Celebrations</h2>
<p>Firecrackers are joy — but only when handled safely. Follow this complete guide to ensure every member of your family enjoys Diwali without any accidents.</p>
<h4>🧯 Before You Start</h4>
<ul>
<li>Always buy crackers from licensed, reputable shops</li>
<li>Read the instructions on every pack before use</li>
<li>Keep a bucket of water and a sand bucket nearby at all times</li>
<li>Wear cotton clothes — synthetic fabrics are highly flammable</li>
</ul>
<h4>👶 Safety for Children</h4>
<ul>
<li>Children under 15 should only handle sparklers — under adult supervision</li>
<li>Keep younger children at least 5 metres away from burst crackers</li>
<li>Never allow children to hold a lit cracker in their hands</li>
</ul>',
                'views' => 556,
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => '10 Safe & Sparkling Crackers for Kids — 2025 Guide',
                'slug' => 'kid-friendly-crackers-2025',
                'category' => 'Kids',
                'excerpt' => 'Make Diwali magical for your little ones with these top 10 kid-friendly crackers.',
                'content' => '<h2>10 Safe & Sparkling Crackers for Kids — 2025 Guide</h2>
<p>Want to make Diwali magical for your little ones without worrying about safety? Here are the top 10 kid-friendly crackers.</p>
<ul>
<li><strong>1. Sparklers (Phooljari)</strong> — Safe under adult supervision, produce brilliant golden sparks</li>
<li><strong>2. Snake Tablets</strong> — No sound, no sparks — just a fascinating growing snake of ash</li>
<li><strong>3. Flower Pots (Anar)</strong> — Shoots colourful sparks upward</li>
<li><strong>4. Ground Spinner (Chakkar)</strong> — Spins on the ground with coloured sparks</li>
<li><strong>5. Colour Smoke Bombs</strong> — Emit coloured smoke, no sparks or fire</li>
</ul>',
                'views' => 284,
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}
