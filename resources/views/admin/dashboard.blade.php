@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')

<div class="dash-header">
    <h1>Dashboard Overview</h1>
    <p>Welcome to your admin dashboard. Quick access to all master data.</p>
</div>

<div class="dash-grid">

   <!-- <a href="{{ route('admin.admission-enquiries', ['status' => 'new']) }}" class="dash-card"> -->
    <a href="" class="dash-card">
    <div class="dash-card-icon"><i class="bi bi-envelope-paper"></i></div>
    <div class="dash-card-body">
        <span class="dash-card-count">{{ $newEnquiries }}</span>
        <span class="dash-card-label">New Enquiries</span>
    </div>
</a>

   <!-- <a href="{{ route('admin.news-notices') }}" class="dash-card"> -->
       <a href="" class="dash-card">
    <div class="dash-card-icon"><i class="bi bi-megaphone"></i></div>
    <div class="dash-card-body">
        <span class="dash-card-count">{{ $activeNotices }}</span>
        <span class="dash-card-label">Active Notices</span>
    </div>
</a>

    <a href="" class="dash-card">
        <div class="dash-card-icon"><i class="bi bi-images"></i></div>
        <div class="dash-card-body">
            <span class="dash-card-count">{{ $activeGallery}}</span>
            <span class="dash-card-label">Media Files</span>
        </div>
    </a>

    <a href="" class="dash-card">
        <div class="dash-card-icon"><i class="bi bi-calendar-event"></i></div>
        <div class="dash-card-body">
            <span class="dash-card-count"></span>
            <span class="dash-card-label">Upcoming Events</span>
        </div>
    </a>

</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <h2 class="quick-actions-title">Quick Actions</h2>

    <div class="quick-actions-grid">
        <a href="{{ route('admin.news-notices.create') }}" class="quick-btn">
            <i class="bi bi-plus-circle"></i>
            Add Notice
        </a>

        <a href="{{ route('admin.events.create') }}" class="quick-btn">
            <i class="bi bi-plus-circle"></i>
            New Event
        </a>

        <a href="{{ route('admin.gallery.create') }}" class="quick-btn">
            <i class="bi bi-plus-circle"></i>
            Upload Media
        </a>

        <a href="{{ route('admin.admission-enquiries') }}" class="quick-btn">
            <i class="bi bi-envelope-open"></i>
            View Enquiries
        </a>
    </div>
</div>

<style>
    .dash-header {
        margin-bottom: 28px;
    }

    .dash-header h1 {
        font-size: 25px;
        font-weight: 700;
        letter-spacing: -0.02em;
        margin: 0;
        color: #171B2C;
    }

    .dash-header p {
        font-size: 13.5px;
        color: #667085;
        margin: 7px 0 0;
    }

    .dash-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .dash-card {
        display: flex;
        align-items: center;
        gap: 16px;
      background: linear-gradient(155deg, #002f5f 0%, #5a7693 100%);
    border-radius: 14px;
    padding: 22px;
    text-decoration: none;
    box-shadow: 0 10px 26px -10px #e5e5e5;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .dash-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 34px -10px #5a7693);
    }

    .dash-card-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        color: #fff;
        font-size: 22px;
    }

    .dash-card-body {
        display: flex;
        flex-direction: column;
    }

    .dash-card-count {
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
    }

    .dash-card-label {
        font-size: 13px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.85);
        margin-top: 4px;
    }

    /* Quick Actions */
    .quick-actions {
        margin-top: 32px;
    }

    .quick-actions-title {
        font-size: 15px;
        font-weight: 700;
        color: #171B2C;
        margin: 0 0 14px;
        letter-spacing: -0.01em;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .quick-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #E9EBF2;
        border-radius: 12px;
        padding: 16px 18px;
        font-size: 13.5px;
        font-weight: 600;
        color: #171B2C;
        text-decoration: none;
        box-shadow: 0 4px 14px -8px rgba(15, 21, 38, 0.12);
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease, color 0.15s ease;
    }

    .quick-btn i {
        font-size: 16px;
        color: #002F5F;
    }

    .quick-btn:hover {
        transform: translateY(-3px);
        border-color: #E7ECF1;
        /* box-shadow: 0 10px 22px -10px rgba(191, 0, 1, 0.35); */
        color: #002F5F;
    }

    @media (max-width: 1200px) {
        .dash-grid,
        .quick-actions-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .dash-grid,
        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 560px) {
        .dash-grid,
        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection