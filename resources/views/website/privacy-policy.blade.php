
@extends('layouts.master')

@section('title', 'Privacy Policy - luxGold')
@section('content')
<!-- Hero -->
  <section class="master-section">
    <div class="container">
      <h1 class="mt-4">AskRoro - Privacy Policy</h1>
    </div>
  </section>

  <!-- Privacy Content -->
  <section class="container privacy-section">
    <h5 class="text-center mb-4"><strong>Effective Date:</strong> January 1st, 2026</h5>

    <p>At luxGold ("luxGold," "we," or "us"), your trust is our highest priority. We are committed to protecting your privacy and handling your data with transparency and care.</p>

    <p>This Privacy Policy describes how we collect, use, share, and safeguard personal data when you use our website, applications, and services (the “Services”).</p>

    <p>By using luxGold, you acknowledge and consent to the practices described here. This Privacy Policy is part of our Terms of Use, which incorporates this policy by reference.</p>

    <p><strong>Contact:</strong> <a href="mailto:privacy@askroro.com">privacy@askroro.com</a><br>
    <strong>Business Address:</strong> Privy Consulting, Inc. Prosper TX.</p>

    <h4>What This Privacy Policy Covers</h4>
    <p>This Privacy Policy explains how we collect, use, share, and protect personal data when you use AskRoro’s website, applications, and services. “Personal Data” means information that identifies, relates to, or can reasonably be linked to a particular individual.</p>

    <h4>Categories of Personal Data We Collect</h4>
    <table>
      <tr>
        <th>Category</th>
        <th>Examples</th>
        <th>Shared With</th>
      </tr>
      <tr>
        <td>Profile / Contact Data</td>
        <td>Name, email, phone, childcare type, location, photo</td>
        <td>Service Providers, Analytics Partners</td>
      </tr>
      <tr>
        <td>Payment Data</td>
        <td>Credit/debit card info, billing details</td>
        <td>Payment Processors (Stripe, Square)</td>
      </tr>
      <tr>
        <td>Device & Online Identifiers</td>
        <td>IP address, login credentials, browser type</td>
        <td>Hosting & Analytics Providers</td>
      </tr>
      <tr>
        <td>Web Analytics</td>
        <td>Browsing history, page interactions, cookies</td>
        <td>Analytics & Advertising Partners</td>
      </tr>
      <tr>
        <td>Demographic / Location Data</td>
        <td>Zip code, city, geo-IP</td>
        <td>Marketing Partners (aggregate only)</td>
      </tr>
      <tr>
        <td>Social Network Data</td>
        <td>Profile info via Facebook, Google, etc.</td>
        <td>Analytics & Service Providers</td>
      </tr>
    </table>

    <h4>Sources of Personal Data</h4>
    <ul>
      <li>You (direct submissions via accounts, forms, surveys, reviews).</li>
      <li>Automatic collection (cookies, device/browser interactions, geolocation).</li>
      <li>Public records (for providers).</li>
      <li>Third parties (vendors, partners, social media logins).</li>
    </ul>

    <h4>Why We Collect Personal Data</h4>
    <ul>
      <li>Create and manage accounts.</li>
      <li>Provide, customize, and improve Services.</li>
      <li>Facilitate payments.</li>
      <li>Connect customers with cleaners safely.</li>
      <li>Send updates and marketing.</li>
      <li>Ensure security, prevent fraud, comply with laws.</li>
    </ul>

    <h4>How We Share Personal Data</h4>
    <p>We may share data with:</p>
    <ul>
      <li>Service Providers (hosting, analytics, support).</li>
      <li>Payment Processors (Stripe, Square).</li>
      <li>Advertising Partners.</li>
      <li>Business Partners (joint promotions).</li>
      <li>Legal Authorities (as required by law).</li>
      <li>During mergers, acquisitions, or sales.</li>
    </ul>
    <p>We may also share de-identified or aggregated data that cannot identify you.</p>

    <h4>Cookies & Tracking</h4>
    <p>We use cookies and similar technologies to:</p>
    <ul>
      <li>Recognize your device.</li>
      <li>Personalize experience.</li>
      <li>Measure traffic & improve features.</li>
      <li>Deliver relevant ads.</li>
    </ul>

    <h4>Children’s Privacy</h4>
    <p>We do not knowingly collect personal data from children under 13. If collected unintentionally, we will delete it promptly.</p>

    <h4>Data Security</h4>
    <p>We use strong technical and organizational measures to protect Personal Data, but no method is 100% secure.</p>

    <h4>Data Retention</h4>
    <p>We retain Personal Data only as long as needed for Services or legal compliance, then anonymize or delete it securely.</p>

    <h4>International Users</h4>
    <p>If you access AskRoro outside the U.S., your data may be stored in the U.S.</p>

    <h4>Updates to this Policy</h4>
    <p>We may update this Privacy Policy. Significant changes will be notified on the site or by email.</p>

    <h4>Contact Us</h4>
    <p>Email: <a href="mailto:privacy@luxgold.com">privacy@luxgold.com</a><br>
    luxGold – Privy Consulting, Inc. Prosper TX</p>
  </section>
@endsection
@push("links")
<style>
    h2, h3, h4 {
      font-weight: 800;
      margin-top: 30px;
      margin-bottom: 15px;
      color: #000;
    }
   p,      li {
          margin-bottom: 12px;
          color:rgb(100, 116, 139) !important;
          font-size: 15px;
        }
        
    .privacy-section a{
      color: #337d7c;  
      font-weight: 600;
    }
    .privacy-section {
      background: #fff;
      border-radius: 12px;
      padding: 40px 30px;
      margin: 40px auto;
    }
    .privacy-section ul {
      padding-left: 18px;
    }
    .privacy-section table {
      width: 100%;
      border: 1px solid #ddd;
      margin: 20px 0;
      border-collapse: collapse;
    }
    .privacy-section th, .privacy-section td {
      border: 1px solid #ddd;
      padding: 10px;
    }
    .privacy-section th {
      background: #337d7c;
      font-weight: 600;
      color: #fff;
    }
  </style>
@endpush
