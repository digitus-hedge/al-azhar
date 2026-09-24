@extends('admin.layout')
@section('title', $staffMember->exists ? 'Edit Staff' : 'Add Staff')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<div class="notice caution" style="margin-bottom:20px;">
    <i class="bi bi-exclamation-triangle" style="font-size:15px;flex-shrink:0;margin-top:1px;"></i>
    <p>Please fill in the highlighted fields below before submitting.</p>
</div>
@endif

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.dashboard') }}'">Home</span>
        <span>&rsaquo;</span>
        <span onclick="window.location='{{ route('admin.staff') }}'">Staff</span>
        <span>&rsaquo;</span>
        <b>{{ $staffMember->exists ? 'Edit' : 'Add' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $staffMember->exists ? 'Edit Staff Member' : 'Add Staff Member' }}</h1>
            <p>{{ $staffMember->exists ? 'Update this staff member\'s details.' : 'Add a new staff member to your website.' }}</p>
        </div>
    </div>

    <form action="{{ $staffMember->exists ? route('admin.staff.update', $staffMember) : route('admin.staff.store') }}"
          method="POST" enctype="multipart/form-data" id="staffForm" novalidate>
        @csrf
        @if ($staffMember->exists)
            @method('PUT')
        @endif

        {{-- Name --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-person"></i></span> Name <span class="req">*</span></h2>
            </div>

            <div class="field">
                <input type="text" name="name" value="{{ old('name', $staffMember->name) }}"
                       class="{{ $errors->has('name') ? 'input-error' : '' }}"
                       placeholder="Enter full name">
                @error('name')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Designation --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-briefcase"></i></span> Designation <span class="req">*</span></h2>
            </div>

            <div class="field">
                <input type="text" name="designation" value="{{ old('designation', $staffMember->designation) }}"
                       class="{{ $errors->has('designation') ? 'input-error' : '' }}"
                       placeholder="e.g. Principal, Head Teacher, Administrator">
                @error('designation')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Department --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-building"></i></span> Department <span class="req">*</span></h2>
            </div>

            <div class="field">
                <select name="department_id" id="department_id"
                        class="{{ $errors->has('department_id') ? 'input-error' : '' }}">
                    <option value="">— Select Department —</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ (int) old('department_id', $staffMember->department_id) === $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
                @if($departments->isEmpty())
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> No departments exist yet — add one first.</span>
                @endif
            </div>
        </div>

        {{-- Class --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-collection"></i></span> Section</h2>
            </div>

            <div class="field">
                <select name="class_id" id="class_id"
                        class="{{ $errors->has('class_id') ? 'input-error' : '' }}">
                    <option value="">— Not linked to a section —</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ (int) old('class_id', $staffMember->class_id) === $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
                <span class="field-hint" style="display:block;margin-top:6px;">Optional — link this staff member to a class (e.g. a class teacher).</span>
            </div>
        </div>

        {{-- Head of Staff --}}
        <div class="card" id="head-of-staff-card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-star"></i></span> Head of Staff</h2>
            </div>
            <label class="toggle-row">
                <input type="hidden" name="is_head_of_staff" value="0">
                <input type="checkbox" name="is_head_of_staff" id="is_head_of_staff" value="1"
                       {{ old('is_head_of_staff', $staffMember->is_head_of_staff) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Mark this person as Head of Staff</span>
            </label>
            <p class="section-sub" style="margin:8px 0 0;">
                Only one Head of Staff is allowed per department. To reassign it, first
                remove this toggle from the current head of staff, then enable it here.
            </p>
            @error('is_head_of_staff')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        {{-- Show on Home Page --}}
        <div class="card" id="show-on-home-card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-house"></i></span> Home Page</h2>
            </div>
            <label class="toggle-row">
                <input type="hidden" name="show_on_home" value="0">
                <input type="checkbox" name="show_on_home" id="show_on_home" value="1"
                       {{ old('show_on_home', $staffMember->show_on_home) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Show this staff member on the Home Page</span>
            </label>
            <p class="section-sub" style="margin:8px 0 0;">
                Turn this on to feature this staff member in the staff section of your site's home page.
            </p>
            @error('show_on_home')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        {{-- Login Access --}}
        <div class="card" id="login-access-card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-shield-lock"></i></span> Login Access</h2>
            </div>
            <label class="toggle-row">
                <input type="hidden" name="has_login" value="0">
                <input type="checkbox" name="has_login" id="has_login" value="1"
                       {{ old('has_login', $staffMember->has_login) ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
                <span class="toggle-label">Give this staff member a login to the site</span>
            </label>
            <p class="section-sub" style="margin:8px 0 0;">
                Turning this on creates a user account for this staff member (using
                the name above), so they can sign in with the email and password
                you set here.
            </p>
            @error('has_login')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror

            <div id="login-fields"
                 style="margin-top:16px; {{ old('has_login', $staffMember->has_login) ? '' : 'display:none;' }}">

                <div class="field" style="margin-bottom:14px;">
                     <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted,#667085);margin-bottom:6px;">
    Email <span class="req">*</span>
</label>
<input type="email" name="login_email" id="login_email"
       value="{{ old('login_email', $staffMember->user->email ?? '') }}"
       class="{{ $errors->has('login_email') ? 'input-error' : '' }}"
       placeholder="staff@example.com">
                    @error('login_email')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field" style="margin-bottom:18px;">
                <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted,#667085);margin-bottom:6px;">
    Password @if(!$staffMember->user_id)<span class="req">*</span>@endif
</label>

<!-- <input type="password" name="login_password" id="login_password" autocomplete="new-password"
       minlength="8"
       class="{{ $errors->has('login_password') ? 'input-error' : '' }}"
       placeholder="{{ $staffMember->user_id ? 'Leave blank to keep current password' : 'Set a password (min 8 characters)' }}"> -->

       <div class="password-wrap">
    <input type="password" name="login_password" id="login_password" autocomplete="new-password"
           class="{{ $errors->has('login_password') ? 'input-error' : '' }}"
           placeholder="{{ $staffMember->user_id ? 'Leave blank to keep current password' : 'Set a password (min 8 characters)' }}">
    <button type="button" class="toggle-password" onclick="togglePassword(this)" title="Show password">
        <i class="bi bi-eye"></i>
    </button>
</div>
                    @error('login_password')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                    <span class="field-hint" style="display:block;margin-top:6px;">Minimum 8 characters.</span>
                </div>

                {{-- Role --}}
                @php
                    $currentRole = old('login_role', $staffMember->user->role ?? 'staff');
                    $currentPermissions = old('login_permissions', $staffMember->user->permissions ?? []);
                @endphp
                <!-- <div class="field" style="margin-bottom:18px;">
                    <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted,#667085);margin-bottom:8px;">Role</label>
                    <div class="role-options">
                        <label class="role-option">
                            <input type="radio" name="login_role" value="admin" id="role_admin"
                                   {{ $currentRole === 'admin' ? 'checked' : '' }}>
                            <span>
                                <b>Admin</b>
                                <small>Full access to every section, including Staff and Departments.</small>
                            </span>
                        </label>
                        <label class="role-option">
                            <input type="radio" name="login_role" value="staff" id="role_staff"
                                   {{ $currentRole !== 'admin' ? 'checked' : '' }}>
                            <span>
                                <b>Staff</b>
                                <small>Restricted — access only the modules checked below.</small>
                            </span>
                        </label>
                    </div>
                    @error('login_role')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div> -->

                {{-- Module Permissions (staff role only) --}}
                <div id="permissions-field" style="{{ $currentRole === 'admin' ? 'display:none;' : '' }}">
                    <label style="display:block;font-size:12.5px;font-weight:600;color:var(--muted,#667085);margin-bottom:8px;">
                        Allowed Modules
                    </label>
                    <div class="permissions-grid">
                        @foreach (\App\Models\User::MODULES as $key => $label)
                            <label class="permission-option">
                                <input type="checkbox" name="login_permissions[]" value="{{ $key }}"
                                       {{ in_array($key, (array) $currentPermissions, true) ? 'checked' : '' }}>
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <span class="field-hint" style="display:block;margin-top:8px;">
                        This staff login can only reach the sections checked here. Everything else
                        (Staff, Departments, Sections, Home settings) stays admin-only.
                    </span>
                    @error('login_permissions')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Photo --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-image"></i></span> Photo
                    @if (!$staffMember->exists) <span class="req">*</span> @endif
                </h2>
            </div>

            <div class="notice caution">
                <i class="bi bi-exclamation-triangle" style="margin-top:1px;"></i>
                <p><b>Recommended size:</b> 400 &times; 400px &middot; JPG, PNG, WEBP &middot; up to 10MB.</p>
            </div>

            <div class="image-slot" style="max-width:220px;">
                <div class="drop img-slot {{ $staffMember->photo ? 'filled' : '' }}" data-file-input="file-photo" id="drop-photo" onclick="handleDropClick(this)">
                    @if ($staffMember->photo)
                        <img src="{{ Storage::url($staffMember->photo) }}" id="preview-photo" alt="Staff photo">
                        <button type="button" class="remove-img-btn" onclick="removeUploadedImage(event, this, 'photo', 'preview-photo')" title="Remove photo">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <div class="uploaded-tag"><i class="bi bi-check-circle"></i> Uploaded</div>
                    @else
                        <div class="preview-placeholder" id="preview-photo">
                            <div class="ico-circle"><i class="bi bi-image" style="color:#AEB4C4;font-size:18px;"></i></div>
                            <div class="drop-title">Click to upload</div>
                            <div class="drop-sub">or drag &amp; drop</div>
                        </div>
                    @endif
                </div>
                <input type="file" id="file-photo" name="photo" accept="image/*" data-max-size="10" hidden
                       onchange="previewImage(this,'preview-photo'); showFileSize(this,'size-photo')">
                <input type="hidden" name="remove_photo" id="remove-photo" value="0">
                @if (!$staffMember->photo)
                    <button type="button" class="choose-btn" onclick="document.getElementById('file-photo').click()">Choose file</button>
                @endif
                <span class="file-size-info" id="size-photo"></span>
            </div>
            @error('photo')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div>

        {{-- Description --}}
        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-code-slash"></i></span> Description</h2>
                <span class="section-sub" id="char-count-msg" style="margin:0;">
                    <span id="char-count">0</span> / 600 characters
                </span>
            </div>

            <textarea name="description" id="description-input" rows="10"
                      class="{{ $errors->has('description') ? 'input-error' : '' }}"
                      placeholder="Write a short bio for this staff member...">{{ old('description', $staffMember->description) }}</textarea>

            @error('description')
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
            @enderror
        </div> -->

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live Staff list</span>
                <div class="btn-group">
                    <a href="{{ route('admin.staff') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#description-input',
        height: 320,
        menubar: false,
        plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen wordcount',
        toolbar: 'undo redo | blocks | bold italic forecolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | link | code preview fullscreen | removeformat help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size:14px }',
        branding: false,
        promotion: false,

        setup: function (editor) {
            const maxChars = 600;

            function updateCounter() {
                editor.save();
                const count = editor.plugins.wordcount ? editor.plugins.wordcount.body.getCharacterCount() : 0;
                const charCountEl = document.getElementById('char-count');
                const charCountMsg = document.getElementById('char-count-msg');

                if (charCountEl && charCountMsg) {
                    charCountEl.textContent = count;
                    if (count > maxChars) {
                        charCountMsg.style.color = '#e74c3c';
                        charCountMsg.style.fontWeight = '600';
                    } else {
                        charCountMsg.style.color = '';
                        charCountMsg.style.fontWeight = '';
                    }
                }
            }

            editor.on('init keyup change paste Undo Redo', updateCounter);

            editor.on('keydown', function (e) {
                const count = editor.plugins.wordcount ? editor.plugins.wordcount.body.getCharacterCount() : 0;
                const allowedKeys = [8, 46, 37, 38, 39, 40];

                if (count >= maxChars && !allowedKeys.includes(e.keyCode) && !e.ctrlKey && !e.metaKey) {
                    e.preventDefault();
                }
            });
        }
    });

    function handleDropClick(el) {
        if (el.classList.contains('filled')) return;
        const inputId = el.getAttribute('data-file-input');
        const input = document.getElementById(inputId);
        if (input) input.click();
    }

    function togglePassword(btn) {
    const input = btn.parentElement.querySelector('input');
    const icon  = btn.querySelector('i');
    const show  = input.type === 'password';

    input.type     = show ? 'text' : 'password';
    icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    btn.title      = show ? 'Hide password' : 'Show password';
}

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (!preview) return;

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.id = previewId;
                preview.replaceWith(img);

                const drop = img.closest('.drop');
                if (drop) {
                    drop.classList.add('filled');
                    const chooseBtn = drop.parentElement.querySelector('.choose-btn');
                    if (chooseBtn) chooseBtn.style.display = 'none';

                    const removeInput = drop.parentElement.querySelector('input[type="hidden"][id^="remove-"]');
                    if (removeInput) removeInput.value = '0';

                    if (!drop.querySelector('.remove-img-btn')) {
                        const fieldName = removeInput ? removeInput.id.replace('remove-', '') : null;
                        if (fieldName) {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'remove-img-btn';
                            btn.title = 'Remove image';
                            btn.innerHTML = '<i class="bi bi-x-lg"></i>';
                            btn.onclick = (ev) => removeUploadedImage(ev, btn, fieldName, previewId);
                            drop.appendChild(btn);
                        }
                    }
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeUploadedImage(event, btn, fieldName, previewId) {
        event.stopPropagation();
        const drop = btn.closest('.drop');
        const wrapper = drop.parentElement;
        const fileInput = wrapper.querySelector('input[type="file"]');
        const removeInput = document.getElementById(`remove-${fieldName}`);

        if (removeInput) removeInput.value = '1';
        if (fileInput) fileInput.value = '';

        drop.classList.remove('filled');
        drop.innerHTML = `
            <div class="preview-placeholder" id="${previewId}">
                <div class="ico-circle"><i class="bi bi-image" style="color:#AEB4C4;font-size:18px;"></i></div>
                <div class="drop-title">Click to upload</div>
                <div class="drop-sub">or drag &amp; drop</div>
            </div>
        `;

        let chooseBtn = wrapper.querySelector('.choose-btn');
        if (!chooseBtn && fileInput) {
            chooseBtn = document.createElement('button');
            chooseBtn.type = 'button';
            chooseBtn.className = 'choose-btn';
            chooseBtn.textContent = 'Choose file';
            chooseBtn.onclick = () => fileInput.click();
            wrapper.appendChild(chooseBtn);
        } else if (chooseBtn) {
            chooseBtn.style.display = 'block';
        }

        const sizeInfo = wrapper.querySelector('.file-size-info');
        if (sizeInfo) sizeInfo.textContent = '';
    }

    function showFileSize(input, displayId) {
        const display = document.getElementById(displayId);
        if (!display) return;
        if (!input.files || !input.files[0]) {
            display.textContent = '';
            display.classList.remove('size-error');
            return;
        }
        const file = input.files[0];
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        const maxMB = parseFloat(input.dataset.maxSize);

        if (sizeMB > maxMB) {
            display.innerHTML = `<i class="bi bi-exclamation-triangle"></i> ${sizeMB} MB — exceeds ${maxMB}MB limit!`;
            display.classList.add('size-error');
        } else {
            display.innerHTML = `<i class="bi bi-check-circle"></i> ${sizeMB} MB`;
            display.classList.remove('size-error');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const firstErrorField = document.querySelector('.input-error, .upload-btn-error');
        const firstErrorMsg = document.querySelector('.field-error');

        if (firstErrorField) {
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstErrorField.classList.add('error-flash');
            setTimeout(() => firstErrorField.classList.remove('error-flash'), 1500);
        } else if (firstErrorMsg) {
            firstErrorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // const hasLoginToggle = document.getElementById('has_login');
        // const loginFields = document.getElementById('login-fields');
        // if (hasLoginToggle && loginFields) {
        //     hasLoginToggle.addEventListener('change', function () {
        //         loginFields.style.display = this.checked ? 'block' : 'none';
        //     });
        // }

        const hasLoginToggle  = document.getElementById('has_login');
const loginFields     = document.getElementById('login-fields');
const loginEmail      = document.querySelector('[name="login_email"]');
const loginPassword   = document.querySelector('[name="login_password"]');
const hasExistingUser = {{ $staffMember->user_id ? 'true' : 'false' }};

function syncLoginRequired() {
    const on = hasLoginToggle.checked;
    loginFields.style.display = on ? 'block' : 'none';
    if (loginEmail)    loginEmail.required    = on;
    if (loginPassword) {
        loginPassword.required  = on && !hasExistingUser;
        loginPassword.minLength = 8;
    }
}

if (hasLoginToggle && loginFields) {
    hasLoginToggle.addEventListener('change', syncLoginRequired);
    syncLoginRequired(); // apply correct state on page load (e.g. editing a staff with login ON)
}

        const roleAdmin = document.getElementById('role_admin');
        const roleStaff = document.getElementById('role_staff');
        const permissionsField = document.getElementById('permissions-field');
        function togglePermissionsField() {
            if (!permissionsField) return;
            permissionsField.style.display = (roleAdmin && roleAdmin.checked) ? 'none' : 'block';
        }
        if (roleAdmin) roleAdmin.addEventListener('change', togglePermissionsField);
        if (roleStaff) roleStaff.addEventListener('change', togglePermissionsField);
    });
</script>


<script>
document.getElementById('staffForm').addEventListener('submit', function (e) {
    e.preventDefault();
    submitStaffForm();
});

function submitStaffForm() {
    const form = document.getElementById('staffForm');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.btn-save');
    const originalBtnHtml = submitBtn.innerHTML;

    form.querySelectorAll('.field-error').forEach(el => el.remove());
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async (response) => {
        const data = await response.json().catch(() => null);

        if (response.status === 422 && data && data.errors) {
            showStaffValidationErrors(data.errors);
            return;
        }

        if (!response.ok) {
            throw new Error('Request failed');
        }

        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: data && data.message ? data.message : 'Staff member saved successfully.',
            confirmButtonColor: '#002F5F',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = "{{ route('admin.staff') }}";
        });
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#002F5F'
        });
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHtml;
    });
}

function showStaffValidationErrors(errors) {
    const form = document.getElementById('staffForm');

    const fieldMap = {
        name: f => f.querySelector('[name="name"]'),
        designation: f => f.querySelector('[name="designation"]'),
        department_id: f => f.querySelector('[name="department_id"]'),
        class_id: f => f.querySelector('[name="class_id"]'),
        photo: f => document.getElementById('drop-photo'),
        description: f => f.querySelector('[name="description"]'),
        is_head_of_staff: f => document.getElementById('head-of-staff-card'),
        show_on_home: f => document.getElementById('show-on-home-card'),
        has_login: f => document.getElementById('login-access-card'),
        login_email: f => f.querySelector('[name="login_email"]'),
      login_password: f => f.querySelector('.password-wrap'),
        login_role: f => document.getElementById('role_staff'),
        login_permissions: f => document.getElementById('permissions-field'),
    };

    const noBorderFields = ['is_head_of_staff', 'show_on_home', 'has_login', 'login_role', 'login_permissions'];

    Object.keys(errors).forEach(field => {
        const message = errors[field][0];
        const target = fieldMap[field] ? fieldMap[field](form) : null;
        if (!target) return;

       if (!noBorderFields.includes(field)) {
    const borderTarget = field === 'login_password' ? target.querySelector('input') : target;
    borderTarget.classList.add('input-error');
}

        // Make sure the Login Access fields are visible before showing an error on them.
        if (['login_email', 'login_password', 'login_role', 'login_permissions'].includes(field)) {
            const loginFields = document.getElementById('login-fields');
            if (loginFields) loginFields.style.display = 'block';
        }

        const errorEl = document.createElement('span');
        errorEl.className = 'field-error';
        errorEl.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${message}`;
        target.insertAdjacentElement('afterend', errorEl);
    });

    const firstErrorField = form.querySelector('.input-error') || document.querySelector('.field-error');
    if (firstErrorField) {
        firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}
</script>


<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span{ cursor:pointer; transition:color .15s; }
    .crumbs span:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }
    .section-sub{ font-size:12px; color: var(--faint,#9AA1B2); transition:color .15s; }

    .field{ margin-bottom:0; }
    input[type=text], input[type=email], input[type=password], textarea, select{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff;
    }
    input[type=text]:focus, input[type=email]:focus, input[type=password]:focus, textarea:focus, select:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .notice{ margin-top:16px; display:flex; align-items:flex-start; gap:8px; background: var(--canvas,#F6F7FB); border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; color: var(--muted,#667085); margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; margin-top:0; margin-bottom:16px; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }
    .notice.caution p b{ color:#6B4A0E; font-weight:700; }

    .drop{
        position:relative; aspect-ratio:1/1; border-radius:12px;
        border:2px dashed var(--input-border,#DBDFEA); background:#FAFBFD;
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        cursor:pointer; overflow:hidden; transition:border-color .15s, background .15s; text-align:center;
    }
    .drop:hover{ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .drop.filled{ border:2px solid transparent; background:#0F1220; cursor:default; }
    .drop img{ width:100%; height:100%; object-fit:cover; display:block; }
    .ico-circle{ width:40px; height:40px; border-radius:999px; background:#EEF0F6; display:flex; align-items:center; justify-content:center; margin-bottom:8px; }
    .drop-title{ font-size:12px; font-weight:500; color: var(--muted,#667085); }
    .drop-sub{ font-size:11px; color:#B0B5C4; margin-top:2px; }
    .uploaded-tag{
        position:absolute; left:0; right:0; bottom:0; padding:8px 12px;
        background:linear-gradient(to top, rgba(0,0,0,0.55), transparent);
        color:rgba(255,255,255,0.9); font-size:11px; display:flex; align-items:center; gap:4px;
    }
    .choose-btn{
        margin-top:8px; width:100%; font-size:12px; font-weight:600; color: var(--orange,#BF0001);
        background:#fff; border:1px solid var(--orange-border,#F3D8C2); border-radius:8px;
        padding:7px 0; cursor:pointer; transition:background .15s;
    }
    .choose-btn:hover{ background: var(--orange-tint,#FFF8F3); }
    .remove-img-btn{
        position:absolute; top:8px; right:8px; width:28px; height:28px; border-radius:999px;
        background:rgba(0,0,0,0.6); border:none; color:#fff; display:flex; align-items:center;
        justify-content:center; cursor:pointer; transition:background .15s; z-index:3; font-size:13px;
    }
    .remove-img-btn:hover{ background:rgba(0,0,0,0.85); }

    .file-size-info{ display:block; font-size:12px; color:#1e8449; margin-top:6px; }
    .file-size-info.size-error{ color:#e74c3c; font-weight:600; }

    .toggle-row{ display:flex; align-items:center; gap:12px; cursor:pointer; }
    .toggle-row input[type="checkbox"]{ position:absolute; opacity:0; width:0; height:0; }
    .toggle-switch{
        position:relative; width:42px; height:24px; border-radius:999px; background:#DBDFEA; flex-shrink:0;
        transition:background .15s;
    }
    .toggle-switch::after{
        content:''; position:absolute; top:2px; left:2px; width:20px; height:20px; border-radius:999px;
        background:#fff; box-shadow:0 1px 2px rgba(0,0,0,0.2); transition:transform .15s;
    }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch{ background: var(--orange,#BF0001); }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch::after{ transform:translateX(18px); }
    .toggle-label{ font-size:13.5px; color: var(--ink,#171B2C); }

    .role-options{ display:flex; gap:12px; flex-wrap:wrap; }
    .role-option{
        display:flex; align-items:flex-start; gap:9px; flex:1; min-width:220px;
        border:1px solid var(--input-border,#DBDFEA); border-radius:10px; padding:12px 14px;
        cursor:pointer; transition:border-color .15s, background .15s;
    }
    .role-option:has(input:checked){ border-color: var(--orange,#BF0001); background: var(--orange-tint,#FFF8F3); }
    .role-option input[type="radio"]{ margin-top:3px; accent-color: var(--orange,#BF0001); }
    .role-option span{ display:flex; flex-direction:column; gap:2px; }
    .role-option b{ font-size:13px; color: var(--ink,#171B2C); }
    .role-option small{ font-size:11.5px; color: var(--faint,#9AA1B2); line-height:1.4; }

    .permissions-grid{
        display:grid; grid-template-columns:repeat(2,1fr); gap:10px;
        background: var(--canvas,#F6F7FB); border-radius:10px; padding:14px;
    }
    .permission-option{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--ink,#171B2C); cursor:pointer; }
    .permission-option input[type="checkbox"]{ accent-color: var(--orange,#BF0001); width:16px; height:16px; }

    .savebar{
        position:sticky; bottom:0; border-top:1px solid var(--line,#E9EBF2);
        background:rgba(255,255,255,0.92); backdrop-filter:blur(6px);
        margin:24px -32px -32px; padding:0 32px;
        box-shadow:0 -4px 16px -8px rgba(15,21,38,0.06);
    }
    .savebar-inner{ padding:16px 0; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
    .savebar-status{ font-size:12px; color: var(--faint,#9AA1B2); }
    .btn-group{ display:flex; align-items:center; gap:12px; }
    .btn-cancel{
        font-size:13px; font-weight:600; color: var(--muted,#667085); background:none; border:none;
        padding:10px 16px; border-radius:8px; cursor:pointer; text-decoration:none; transition:color .15s, background .15s;
    }
    .btn-cancel:hover{ color: var(--ink,#171B2C); background: var(--canvas,#F6F7FB); }
    .btn-save{
        display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#fff;
        background:linear-gradient(135deg, #0F1526, #1D2439); border:none;
        padding:11px 22px; border-radius:9px; cursor:pointer;
        box-shadow:0 4px 12px -4px rgba(15,21,38,0.4);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .btn-save:hover{ transform:translateY(-1px); box-shadow:0 8px 18px -6px rgba(15,21,38,0.5); }

    .req { color: #BF0001; }

    div#show-on-home-card {
    margin-top: 15px;
}

.password-wrap{ position:relative; }
.password-wrap input{ padding-right:44px; }
.toggle-password{
    position:absolute; top:50%; right:8px; transform:translateY(-50%);
    width:32px; height:32px; border:none; background:none; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    color: var(--faint,#9AA1B2); font-size:16px; cursor:pointer;
    transition:color .15s, background .15s;
}
.toggle-password:hover{ color: var(--ink,#171B2C); background: var(--canvas,#F6F7FB); }

</style>

@endsection
