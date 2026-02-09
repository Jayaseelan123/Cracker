@extends('layouts.front')

@section('title', 'About Us')
@section('hero_title', 'About Crackers Time')
@section('hero_subtitle', 'Trusted Fireworks & Crackers Supplier Since 2016')

@section('content')

<style>
.about-card {
    background:#fff;
    border-radius:15px;
    padding:30px;
    box-shadow:0 6px 20px rgba(0,0,0,.1);
    margin-top:20px;
}

/* ===== ANIMATIONS ===== */
.animate{
    opacity:0;
    transform:translateY(40px);
    transition:all .8s ease;
}

.animate.show{
    opacity:1;
    transform:translateY(0);
}

.zoom{transform:scale(.9)}
.zoom.show{transform:scale(1)}

.delay-1{transition-delay:.2s}
.delay-2{transition-delay:.4s}
.delay-3{transition-delay:.6s}

.highlight-box{
    background:linear-gradient(135deg,#ffefba,#fff);
    border-radius:12px;
    padding:20px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.icon-badge{font-size:40px}

.title-line{
    width:60px;
    height:4px;
    background:#ff9900;
    margin:10px auto 20px;
}

.about-ul li{margin-bottom:8px}
</style>

<div class="container">
<div class="row">
<div class="col-md-10 offset-md-1">

<div class="about-card animate">

<h2 class="fw-bold text-center animate delay-1">About Crackers Time 🎉</h2>
<div class="title-line"></div>

<p class="text-center text-muted animate delay-2">
India’s most trusted & loved fireworks supplier since 2016.
</p>

<h4 class="fw-bold mt-4 animate delay-1">Welcome to Crackers Time!</h4>

<p class="animate delay-2">
For the last 8 years, we’ve been delivering joy, excitement, and premium-quality crackers all over India.
Our mission is simple — to make your celebrations brighter, safer, and unforgettable.
</p>

<h5 class="fw-bold mt-4 animate delay-1">Why Choose Us? ✨</h5>

<ul class="about-ul animate delay-2">
<li>✔ Quality Assured</li>
<li>✔ Huge Variety</li>
<li>✔ Best Pricing</li>
<li>✔ 24/7 Support</li>
</ul>

<div class="row text-center mt-4">

<div class="col-md-4 mb-3">
<div class="highlight-box animate zoom delay-1">
<div class="icon-badge">🏆</div>
<h6>Licensed & Certified</h6>
<small>100% safe fireworks</small>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="highlight-box animate zoom delay-2">
<div class="icon-badge">🚚</div>
<h6>Free Delivery</h6>
<small>Across India</small>
</div>
</div>

<div class="col-md-4 mb-3">
<div class="highlight-box animate zoom delay-3">
<div class="icon-badge">📞</div>
<h6>24/7 Support</h6>
<small>Always available</small>
</div>
</div>

</div>

<h5 class="fw-bold mt-4 animate delay-1">Our Promise 💛</h5>

<p class="animate delay-2">
We promise premium crackers, reliable service, and unforgettable celebrations every time.
</p>

</div>
</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded",()=>{

const observer=new IntersectionObserver(entries=>{
entries.forEach(e=>{
if(e.isIntersecting){
e.target.classList.add("show");
}
});
},{threshold:.2});

document.querySelectorAll(".animate").forEach(el=>observer.observe(el));

});
</script>

@endsection
