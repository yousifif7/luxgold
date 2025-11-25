@extends('layouts.master')

@section('title', 'Cookies Policy - luxGold')
@section('content')
  <!-- Hero -->
  <section class="master-section">
    <div class="container">
      <h1 class="mt-4">luxGold – Cookie Policy</h1>
    </div>
  </section>

  <!-- Cookie Policy Content -->
  <section class="container policy-section">
    <h5 class="text-center mb-4"><strong>Effective Date:</strong> January 1, 2026</h5>

    <p>At luxGold (“luxGold,” “we,” “our,” or “us”), we use cookies and similar technologies to improve your experience on our website and applications (the “Services”). This Cookie Policy explains what cookies are, how we use them, and your choices.</p>

    <h4>What Are Cookies?</h4>
    <p>Cookies are small text files that are placed on your computer, phone, or tablet when you visit a website. They help us recognize your device, store preferences, and make your interactions with luxGold faster and more personalized.</p>
    <p>We also use related technologies such as pixels, tags, and web beacons. Together, we call these “Cookies.”</p>

    <h4>Types of Cookies We Use</h4>
    <ul>
      <li><strong>Essential Cookies</strong> – Required for core functionality (e.g., staying logged in, saving preferences, secure payments).</li>
      <li><strong>Functional Cookies</strong> – Personalize your experience (e.g., remembering language or location).</li>
      <li><strong>Performance / Analytics Cookies</strong> – Help us understand usage (e.g., Google Analytics).</li>
      <li><strong>Advertising / Targeting Cookies</strong> – Deliver relevant ads and track browsing for interest profiles.</li>
    </ul>

    <h4>Why We Use Cookies</h4>
    <ul>
      <li>To make luxGold easier to use and navigate.</li>
      <li>To personalize your experience.</li>
      <li>To measure performance and improve services.</li>
      <li>To deliver ads and sponsored content relevant to you.</li>
    </ul>

    <h4>Third-Party Cookies</h4>
    <p>Some Cookies are placed by third parties (such as Google, Meta, or advertising partners). These may be used for analytics, ads, or social media integration. Their use is governed by their own privacy policies.</p>

    <h4>Your Choices</h4>
    <ul>
      <li>Control via browser settings (refuse or delete Cookies).</li>
      <li>Opt out of targeted advertising via <a href="https://www.networkadvertising.org" target="_blank">Network Advertising Initiative</a> or <a href="https://www.youronlinechoices.com" target="_blank">Your Online Choices</a>.</li>
      <li>Adjust preferences in our Cookie banner upon first visit.</li>
    </ul>
    <p><em>Note:</em> If you disable Cookies, some features of luxGold may not work properly.</p>

    <h4>Changes to this Policy</h4>
    <p>We may update this Cookie Policy from time to time. Significant changes will be notified on the site or by email.</p>

    <h4>Contact Us</h4>
    <p>Email: <a href="mailto:privacy@luxgold.com">privacy@luxgold.com</a><br>
    Privy Consulting, Inc., Prosper, TX [Insert full address]</p>
  </section>

@endsection

@push("links")
<style>
    h2, h3, h4 {
      font-weight: 700;
      margin-top: 30px;
      margin-bottom: 15px;
      color: #000;
    }
    .policy-section p, .policy-section li {
      margin-bottom: 12px;
      color: rgb(100, 116, 139);
      font-size: 15px;
    }
    .policy-section a {
      color: #337d7c;
      font-weight: 600;
    }
    .policy-section {
      background: #fff;
      border-radius: 12px;
      padding: 40px 30px;
      margin: 40px auto;
    }
    .policy-section ul {
      padding-left: 18px;
    }
  </style>
@endpush