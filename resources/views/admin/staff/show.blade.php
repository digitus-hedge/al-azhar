@extends('admin.layout')
@section('title', $staffMember->name . ' — Staff')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@php
    $designationName    = $staffMember->designation ?? $staffMember->staffDesignation?->name;
    $designationDeleted = $staffMember->staffDesignation?->trashed();
    $user               = $staffMember->user;
    $permissions        = (array) ($user->permissions ?? []);
    $modules            = \App\Models\User::MODULES;
    $initials           = collect(explode(' ', trim($staffMember->name)))
                            ->filter()->take(2)
                            ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                            ->implode('');
@endphp

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.staff') }}'">Staff</span>
        <span>&rsaquo;</span>
        <b>View</b>
    </div>

    <div class="header">
        <div>
            <h1>Staff Details</h1>
            <p>Full profile of this staff member as saved in the system.</p>
        </div>
        <!-- <div class="header-actions">
            <a href="{{ route('admin.staff') }}" class="btn-ghost">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.staff.edit', $staffMember) }}" class="btn-save">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div> -->
    </div>

    <div class="view-grid">
        {{-- ================= Left: profile card ================= --}}
        <div class="card profile-card">
            <div class="profile-photo">
                @if ($staffMember->photo)
                    <img src="{{ Storage::url($staffMember->photo) }}" alt="{{ $staffMember->name }}">
                @else
                    <span class="profile-initials">{{ $initials ?: '?' }}</span>
                @endif
            </div>

            <h2 class="profile-name">{{ $staffMember->name }}</h2>

            @if ($designationName)
                <div class="profile-role {{ $designationDeleted ? 'is-deleted' : '' }}"
                     title="{{ $designationDeleted ? 'This designation was deleted' : '' }}">
                    {{ $designationName }}
                </div>
            @endif

            <div class="profile-badges">
                @if ($staffMember->is_head_of_staff)
                    <span class="badge-head"><i class="bi bi-star-fill"></i> Head of Staff</span>
                @endif
                @if ($staffMember->show_on_home)
                    <span class="badge-home"><i class="bi bi-house-fill"></i> On Home Page</span>
                @endif
                @if ($staffMember->has_login)
                    <span class="badge-access"><i class="bi bi-check-circle-fill"></i> Login Access</span>
                @else
                    <span class="badge-no-access"><i class="bi bi-x-circle-fill"></i> No Login</span>
                @endif
            </div>

            <div class="profile-meta">
                <div><i class="bi bi-calendar-plus"></i> Added {{ optional($staffMember->created_at)->format('d M Y') ?? '—' }}</div>
                <div><i class="bi bi-clock-history"></i> Updated {{ optional($staffMember->updated_at)->diffForHumans() ?? '—' }}</div>
            </div>
        </div>

        {{-- ================= Right: details ================= --}}
        <div class="details-col">
            {{-- Basic details --}}
            <div class="card">
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-person-vcard"></i></span> Basic Details</h2>
                </div>

                <dl class="info-list">
                    <div class="info-row">
                        <dt>Full Name</dt>
                        <dd>{{ $staffMember->name }}</dd>
                    </div>
                    <div class="info-row">
                        <dt>Designation</dt>
                        <dd>
                            @if ($designationName)
                                <span class="{{ $designationDeleted ? 'is-deleted' : '' }}">{{ $designationName }}</span>
                                @if ($designationDeleted) <span class="muted-sub">(deleted)</span> @endif
                            @else
                                <span class="muted">—</span>
                            @endif
                        </dd>
                    </div>
                    <div class="info-row">
                        <dt>Department</dt>
                        <dd>{!! $staffMember->department?->name ? e($staffMember->department->name) : '<span class="muted">—</span>' !!}</dd>
                    </div>
                    <div class="info-row">
                        <dt>Section</dt>
                        <dd>{!! $class?->name ? e($class->name) : '<span class="muted">Not linked to a section</span>' !!}</dd>
                    </div>
                    <div class="info-row">
                        <dt>Head of Staff</dt>
                        <dd>
                            @if ($staffMember->is_head_of_staff)
                                <span class="yes"><i class="bi bi-check-lg"></i> Yes</span>
                            @else
                                <span class="muted">No</span>
                            @endif
                        </dd>
                    </div>
                    <div class="info-row">
                        <dt>Home Page</dt>
                        <dd>
                            @if ($staffMember->show_on_home)
                                <span class="yes"><i class="bi bi-check-lg"></i> Shown on the Home Page</span>
                            @else
                                <span class="muted">Not shown</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Login access --}}
            <div class="card">
                <div class="section-title">
                    <h2><span class="icon"><i class="bi bi-shield-lock"></i></span> Login Access</h2>
                    @if ($staffMember->has_login)
                        <span class="badge-access"><i class="bi bi-check-circle-fill"></i> Enabled</span>
                    @else
                        <span class="badge-no-access"><i class="bi bi-x-circle-fill"></i> Disabled</span>
                    @endif
                </div>

                @if ($staffMember->has_login && $user)
                    <dl class="info-list">
                        <div class="info-row">
                            <dt>Login Email</dt>
                            <dd><a href="mailto:{{ $user->email }}" class="link">{{ $user->email }}</a></dd>
                        </div>
                        <div class="info-row">
                            <dt>Role</dt>
                            <dd>{{ ucfirst($user->role ?? 'staff') }}</dd>
                        </div>
                        <div class="info-row">
                            <dt>Last Login</dt>
                            <dd>{{ $user->last_login_at ?? null ? \Illuminate\Support\Carbon::parse($user->last_login_at)->format('d M Y, h:i A') : '—' }}</dd>
                        </div>
                    </dl>

                    @if (($user->role ?? 'staff') === 'admin')
                        <div class="notice">
                            <i class="bi bi-info-circle"></i>
                            <p>This account is an <b>Admin</b> and can access every section.</p>
                        </div>
                    @else
                        <div class="perm-title">Allowed Modules</div>
                        @if (count($permissions))
                            <div class="perm-list">
                                @foreach ($modules as $key => $label)
                                    @if (in_array($key, $permissions, true))
                                        <span class="perm-chip"><i class="bi bi-check2"></i> {{ $label }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="muted" style="font-size:13px;margin:0;">No modules allowed yet. This staff login can sign in but can't open any section.</p>
                        @endif
                    @endif
                @else
                    <p class="muted" style="font-size:13px;margin:0;">This staff member can't sign in to the admin panel. Turn on Login Access from the Edit page to create an account.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Bottom actions --}}
    <div class="view-actions">
        <a href="{{ route('admin.staff') }}" class="btn-ghost"><i class="bi bi-arrow-left"></i> Back to Staff</a>
        <div class="view-actions-right">
            <button type="button" class="btn-danger-ghost"
                    onclick="confirmDeleteStaff({{ $staffMember->id }}, @js($staffMember->name))">
                <i class="bi bi-trash"></i> Delete
            </button>
            <form id="delete-form-{{ $staffMember->id }}" action="{{ route('admin.staff.destroy', $staffMember) }}"
                  method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
            <a href="{{ route('admin.staff.edit', $staffMember) }}" class="btn-save">
                <i class="bi bi-pencil"></i> Edit Staff
            </a>
        </div>
    </div>
</div>

<script>
function confirmDeleteStaff(id, name) {
    Swal.fire({
        icon: 'warning',
        title: 'Remove staff member?',
        text: `"${name}" will be removed from the staff list.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#002F5F',
        cancelButtonColor: '#667085'
    }).then((result) => {
        if (result.isConfirmed) document.getElementById(`delete-form-${id}`).submit();
    });
}
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; flex-wrap:wrap; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span[onclick]{ cursor:pointer; transition:color .15s; }
    .crumbs span[onclick]:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }
    .header-actions{ display:flex; gap:10px; align-items:center; }

    .btn-save{
        display:inline-flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff; text-decoration:none;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 20px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); color:#fff; }
    .btn-ghost{
        display:inline-flex; align-items:center; gap:7px; font-size:13px; font-weight:600; text-decoration:none;
        color: var(--muted,#667085); background:#fff; border:1px solid var(--line,#E9EBF2);
        padding:10px 16px; border-radius:9px; transition:background .15s, color .15s;
    }
    .btn-ghost:hover{ background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); }
    .btn-danger-ghost{
        display:inline-flex; align-items:center; gap:7px; font-size:13px; font-weight:600; font-family:inherit;
        color:#C62828; background:#fff; border:1px solid #F5C6C6; padding:10px 16px; border-radius:9px; cursor:pointer;
        transition:background .15s;
    }
    .btn-danger-ghost:hover{ background:#FFF5F5; }

    /* Layout */
    .view-grid{ display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start; }
    .details-col{ display:flex; flex-direction:column; gap:20px; min-width:0; }
    .details-col .card{ margin:0; }

    /* Profile card */
    .profile-card{ text-align:center; padding:28px 22px; margin:0; position:sticky; top:20px; }
    .profile-photo{
        width:140px; aspect-ratio:3/4; margin:0 auto 16px; border-radius:14px; overflow:hidden;
        background:#EEF0F6; display:flex; align-items:center; justify-content:center;
        box-shadow:0 6px 18px -8px rgba(15,21,38,0.25);
    }
    .profile-photo img{ width:100%; height:100%; object-fit:cover; object-position:center top; display:block; }
    .profile-initials{ font-size:40px; font-weight:700; color:#8A92A6; letter-spacing:.02em; }
    .profile-name{ font-size:18px; font-weight:700; color: var(--ink,#171B2C); margin:0; line-height:1.3; word-break:break-word; }
    .profile-role{ font-size:13.5px; color: var(--muted,#667085); margin-top:4px; }
    .profile-badges{ display:flex; flex-wrap:wrap; justify-content:center; gap:6px; margin-top:14px; }
    .profile-meta{
        margin-top:18px; padding-top:16px; border-top:1px solid var(--line,#E9EBF2);
        display:flex; flex-direction:column; gap:6px; font-size:12px; color: var(--faint,#9AA1B2);
    }
    .profile-meta i{ margin-right:4px; }

    /* Badges */
    .badge-head, .badge-home, .badge-access, .badge-no-access{
        display:inline-flex; align-items:center; gap:5px; font-size:11.5px; font-weight:600;
        padding:4px 10px; border-radius:999px; white-space:nowrap;
    }
    .badge-head{ color:#8A6116; background:#FFF8E8; border:1px solid #F5E3B3; }
    .badge-home{ background:#EEF2FF; color:#3538CD; }
    .badge-access{ background:#E6F6EC; color:#1E8E4E; }
    .badge-no-access{ background:#FDECEC; color:#C62828; }

    /* Sections */
    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:8px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }

    .info-list{ margin:0; }
    .info-row{
        display:grid; grid-template-columns:160px 1fr; gap:12px;
        padding:11px 0; border-bottom:1px dashed var(--line,#E9EBF2);
    }
    .info-row:last-child{ border-bottom:none; }
    .info-row dt{ font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color: var(--faint,#9AA1B2); padding-top:1px; }
    .info-row dd{ margin:0; font-size:14px; color: var(--ink,#171B2C); word-break:break-word; }

    .muted{ color: var(--faint,#9AA1B2); }
    .muted-sub{ font-size:12px; color: var(--faint,#9AA1B2); }
    .yes{ color:#1E8E4E; font-weight:600; }
    .is-deleted{ color:#8A92A6; text-decoration:line-through; }
    .link{ color: var(--orange,#BF0001); text-decoration:none; }
    .link:hover{ text-decoration:underline; }

    .perm-title{ font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color: var(--faint,#9AA1B2); margin:16px 0 10px; }
    .perm-list{ display:flex; flex-wrap:wrap; gap:8px; }
    .perm-chip{
        display:inline-flex; align-items:center; gap:5px; font-size:12.5px; font-weight:600;
        background: var(--canvas,#F6F7FB); color: var(--ink,#171B2C); border:1px solid var(--line,#E9EBF2);
        padding:5px 11px; border-radius:8px;
    }
    .perm-chip i{ color:#1E8E4E; }

    .notice{ display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; margin-top:14px; }
    .notice i{ color: var(--muted,#667085); margin-top:1px; }
    .notice p{ font-size:12.5px; color: var(--muted,#667085); margin:0; }

    .view-actions{
        display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;
        margin-top:24px; padding-top:18px; border-top:1px solid var(--line,#E9EBF2);
    }
    .view-actions-right{ display:flex; gap:10px; align-items:center; }

    /* ================= Responsive ================= */
    @media (max-width: 900px){
        .view-grid{ grid-template-columns:1fr; }
        .profile-card{ position:static; display:grid; grid-template-columns:110px 1fr; gap:4px 18px; text-align:left; align-items:center; padding:20px; }
        .profile-photo{ width:110px; margin:0; grid-row:span 4; }
        .profile-badges{ justify-content:flex-start; margin-top:8px; }
        .profile-meta{ grid-column:1 / -1; flex-direction:row; flex-wrap:wrap; gap:6px 18px; }
    }

    @media (max-width: 640px){
        .header{ flex-direction:column; align-items:stretch; margin-bottom:18px; }
        .header h1{ font-size:21px; }
        .header p{ font-size:13px; }
        .header-actions{ display:none; } /* bottom bar has the same buttons */

        .profile-card{ grid-template-columns:1fr; text-align:center; }
        .profile-photo{ width:120px; margin:0 auto 12px; grid-row:auto; }
        .profile-badges{ justify-content:center; }
        .profile-meta{ justify-content:center; }

        .info-row{ grid-template-columns:1fr; gap:3px; }

        .view-actions{ flex-direction:column-reverse; align-items:stretch; }
        .view-actions-right{ flex-direction:column-reverse; align-items:stretch; }
        .view-actions .btn-save,
        .view-actions .btn-ghost,
        .view-actions .btn-danger-ghost{ justify-content:center; width:100%; padding:12px 16px; }
    }
</style>

@endsection