@extends('admin.layout')
@section('title', $fee->exists ? 'Edit Fee' : 'Add Fee')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<div class="notice caution" style="margin-bottom:20px;">
    <i class="bi bi-exclamation-triangle" style="font-size:15px;flex-shrink:0;margin-top:1px;"></i>
    <p>Please fix the highlighted fields below before submitting.</p>
</div>
@endif

<div class="wrap">
    <div class="crumbs">
        <span onclick="window.location='{{ route('admin.fees') }}'">Fees</span>
        <span>&rsaquo;</span>
        <b>{{ $fee->exists ? 'Edit' : 'Add New' }}</b>
    </div>

    <div class="header">
        <div>
            <h1>{{ $fee->exists ? 'Edit Fee' : 'Add Fee' }}</h1>
            <p>Set the fee per instalment for a class. The yearly total is calculated automatically.</p>
        </div>
        <a href="{{ route('admin.fees') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to list
        </a>
    </div>

    <form action="{{ $fee->exists ? route('admin.fees.update', $fee->id) : route('admin.fees.store') }}"
          method="POST" id="feeForm">
        @csrf
        @if ($fee->exists)
            @method('PUT')
        @endif

        {{-- Class --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-mortarboard"></i></span> Class<span class="req">*</span></h2>
            </div>
            <div class="field" style="margin-bottom:0;">
           <select name="class_name" id="class_name" class="{{ $errors->has('class_name') ? 'input-error' : '' }}">
                    <option value="">-- Select Class --</option>
                    @foreach (\App\Models\Fee::CLASSES as $class)
                        <option value="{{ $class }}" {{ old('class_name', $fee->class_name) === $class ? 'selected' : '' }}>
                            {{ $class }}
                        </option>
                    @endforeach
                </select>
                @error('class_name')
                    <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Fee details --}}
        <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-cash-coin"></i></span> Fee Details<span class="req">*</span></h2>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label class="field-label">Fee per instalment (₹)<span class="req">*</span></label>
                    <input type="number" name="fee_amount" id="fee_amount" step="0.01" min="0"
                           value="{{ old('fee_amount', $fee->fee_amount) }}"
                           class="{{ $errors->has('fee_amount') ? 'input-error' : '' }}"
                           placeholder="e.g. 4625.00">
                    @error('fee_amount')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="field-label">Number of instalments<span class="req">*</span></label>
                    <input type="number" name="installments" id="installments" min="1" max="12"
                           value="{{ old('installments', $fee->installments ?? 4) }}"
                           class="{{ $errors->has('installments') ? 'input-error' : '' }}"
                           placeholder="e.g. 4">
                    @error('installments')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="total-box">
                <div>
                    <div class="total-label">Yearly total</div>
                    <div class="total-formula" id="totalFormula">₹0.00 × 0</div>
                </div>
                <div class="total-value" id="totalValue">₹0.00</div>
            </div>
        </div>

        {{-- Display settings --}}
        <!-- <div class="card">
            <div class="section-title">
                <h2><span class="icon"><i class="bi bi-sliders"></i></span> Display Settings</h2>
            </div>

            <div class="grid-2">
                <div class="field">
                    <label class="field-label">Sort order</label>
                    <input type="number" name="sort_order" min="0"
                           value="{{ old('sort_order', $fee->sort_order ?? 0) }}"
                           class="{{ $errors->has('sort_order') ? 'input-error' : '' }}"
                           placeholder="e.g. 1 for Pre.KG, 2 for LKG">
                    @error('sort_order')
                        <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label class="field-label">Status</label>
                    <label class="toggle-row">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $fee->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        <span class="toggle-label">Show on website</span>
                    </label>
                </div>
            </div>
        </div> -->

        <div class="savebar">
            <div class="savebar-inner">
                <span class="savebar-status">All changes save to the live Fees page</span>
                <div class="btn-group">
                    <a href="{{ route('admin.fees') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">
                        <i class="bi bi-check-lg"></i>
                        {{ $fee->exists ? 'Update' : 'Save' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
/* ---------- Live total ---------- */
function formatINR(n) {
    return '₹' + Number(n || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function updateTotal() {
    const amount = parseFloat(document.getElementById('fee_amount').value) || 0;
    const count  = parseInt(document.getElementById('installments').value, 10) || 0;
    document.getElementById('totalFormula').textContent = formatINR(amount) + ' × ' + count;
    document.getElementById('totalValue').textContent   = formatINR(amount * count);
}

['fee_amount', 'installments'].forEach(id => {
    document.getElementById(id).addEventListener('input', updateTotal);
});
updateTotal();

/* ---------- AJAX submit ---------- */
document.getElementById('feeForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector('.btn-save');
    const originalBtnHtml = submitBtn.innerHTML;

    form.querySelectorAll('.field-error').forEach(el => el.remove());
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Saving...';

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(async (response) => {
        const data = await response.json().catch(() => null);

        if (response.status === 422 && data && data.errors) {
            showFeeErrors(data.errors);
            return;
        }
        if (!response.ok) throw new Error('Request failed');

        Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: (data && data.message) ? data.message : 'Fee saved successfully.',
            confirmButtonColor: '#002F5F',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = (data && data.redirect) ? data.redirect : "{{ route('admin.fees') }}";
        });
    })
    .catch(() => {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#BF0001' });
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHtml;
    });
});

new TomSelect('#class_name', {
    create: false,
    allowEmptyOption: true,
    controlInput: null,          // no typing box, works like a normal dropdown
    maxOptions: null,
    dropdownParent: 'body',
    onInitialize() {
        this.wrapper.classList.toggle('input-error', this.input.classList.contains('input-error'));
    }
});


function showFeeErrors(errors) {
    const form = document.getElementById('feeForm');

  Object.keys(errors).forEach(field => {
    const target = form.querySelector(`[name="${field}"]:not([type="hidden"])`);
    if (!target) return;

    target.classList.add('input-error');

    // Tom Select: mark the visible box red
    if (target.tomselect) {
        target.tomselect.wrapper.classList.add('input-error');
    }

    const errorEl = document.createElement('span');
    errorEl.className = 'field-error';
    errorEl.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${errors[field][0]}`;

    // Place the message below the visible element
    const anchor = target.tomselect
        ? target.tomselect.wrapper
        : (target.closest('.toggle-row') || target);

    anchor.insertAdjacentElement('afterend', errorEl);
});

    const first = form.querySelector('.input-error');
    if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
}
</script>

<style>
    .crumbs{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--faint,#9AA1B2); margin-bottom:10px; }
    .crumbs b{ color: var(--ink,#171B2C); font-weight:600; }
    .crumbs span:first-child{ cursor:pointer; transition:color .15s; }
    .crumbs span:first-child:hover{ color: var(--orange,#BF0001); }

    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:32px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; max-width:560px; line-height:1.55; }

    .btn-back{
        display:inline-flex; align-items:center; gap:6px; padding:9px 16px; font-size:13px; font-weight:600;
        color: var(--muted,#667085); background:#fff; border:1px solid var(--line,#E9EBF2); border-radius:9px;
        text-decoration:none; transition:all .15s ease; white-space:nowrap;
    }
    .btn-back:hover{ background: var(--orange,#BF0001); border-color: var(--orange,#BF0001); color:#fff; }

    .section-title{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:6px; }
    .section-title h2{ display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; margin:0; color: var(--ink,#171B2C); }
    .icon{ display:inline-flex; color: var(--orange,#BF0001); }
    .req{ color: var(--orange,#BF0001); }

    .field{ margin-bottom:18px; }
    .field-label{ display:flex; align-items:center; gap:4px; font-size:13px; font-weight:600; color: var(--ink,#171B2C); margin-bottom:8px; }
    .grid-2{ display:grid; grid-template-columns:1fr 1fr; gap:0 16px; }
    @media (max-width:720px){ .grid-2{ grid-template-columns:1fr; } }

    input[type=text], input[type=number]{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:11px 14px; font-size:14px; font-family:inherit; color: var(--ink,#171B2C);
        outline:none; transition:box-shadow .15s, border-color .15s; background:#fff; box-sizing:border-box;
    }
    input[type=text]:focus, input[type=number]:focus{
        border-color: var(--orange,#BF0001);
        box-shadow: 0 0 0 4px var(--orange-tint-strong,#FFE9D8);
    }
    .input-error{ border-color:#e74c3c !important; background:#fff8f8 !important; }
    .field-error{ display:flex; align-items:center; gap:5px; color:#e74c3c; font-size:12.5px; margin-top:6px; }

    .notice{ display:flex; align-items:flex-start; gap:8px; border-radius:10px; padding:10px 12px; }
    .notice p{ font-size:12px; margin:0; }
    .notice.caution{ background:#FFF8E8; border:1px solid #F5E3B3; }
    .notice.caution i{ color:#B7791F; }
    .notice.caution p{ color:#8A6116; }

    /* Total preview */
    .total-box{
        display:flex; align-items:center; justify-content:space-between; gap:12px;
        background: var(--orange-tint,#FFF8F3); border:1px solid var(--orange-border,#F3D8C2);
        border-radius:12px; padding:14px 18px;
    }
    .total-label{ font-size:12px; font-weight:600; color: var(--muted,#667085); text-transform:uppercase; letter-spacing:.04em; }
    .total-formula{ font-size:13px; color: var(--muted,#667085); margin-top:3px; }
    .total-value{ font-size:22px; font-weight:700; color: var(--orange,#BF0001); }

    /* Toggle */
    .toggle-row{ display:flex; align-items:center; gap:12px; cursor:pointer; position:relative; padding-top:8px; }
    .toggle-row input[type="checkbox"]{ position:absolute; opacity:0; width:0; height:0; }
    .toggle-switch{ position:relative; width:42px; height:24px; border-radius:999px; background:#DBDFEA; flex-shrink:0; transition:background .15s; }
    .toggle-switch::after{
        content:''; position:absolute; top:2px; left:2px; width:20px; height:20px; border-radius:999px;
        background:#fff; box-shadow:0 1px 2px rgba(0,0,0,0.2); transition:transform .15s;
    }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch{ background: var(--orange,#BF0001); }
    .toggle-row input[type="checkbox"]:checked + .toggle-switch::after{ transform:translateX(18px); }
    .toggle-label{ font-size:13.5px; color: var(--ink,#171B2C); }

    /* Save bar */
    .savebar{
        position:fixed; left:264px; right:0; bottom:0; z-index:20;
        border-top:1px solid var(--line,#E9EBF2);
        background:rgba(255,255,255,0.96); backdrop-filter:blur(6px);
        padding:0 32px; box-shadow:0 -4px 16px -8px rgba(15,21,38,0.06);
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
    .btn-save:disabled{ opacity:.7; cursor:wait; transform:none; }

    .wrap{ padding-bottom:90px; }
    @media (max-width:900px){ .savebar{ left:0; } }

 #feeForm select {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid var(--input-border, #DBDFEA);
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 14px;
    font-family: inherit;
    color: var(--ink, #171B2C);
    background: #fff;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}

#feeForm select:focus {
    border-color: var(--orange, #002F5F);
    box-shadow: 0 0 0 4px var(--orange-tint-strong, #E7ECF1);
}

#feeForm select.input-error {
    border-color: #e74c3c !important;
}

#feeForm select.input-error:focus {
    box-shadow: 0 0 0 4px #FDECEC;
}

#feeForm .ts-wrapper { width: 100%; }

#feeForm .ts-control {
    border: 1px solid var(--input-border, #DBDFEA);
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 14px;
    font-family: inherit;
    color: var(--ink, #171B2C);
    background: #fff;
    box-shadow: none;
    min-height: 46px;
    cursor: pointer;
}

#feeForm .ts-wrapper.focus .ts-control {
    border-color: var(--orange, #002F5F);
    box-shadow: 0 0 0 4px var(--orange-tint-strong, #E7ECF1);
}

#feeForm .ts-wrapper.input-error .ts-control {
    border-color: #e74c3c;
    background: #fff8f8;
}

.ts-dropdown {
    border: 1px solid var(--input-border, #DBDFEA);
    border-radius: 10px;
    margin-top: 6px;
    box-shadow: 0 10px 24px -10px rgba(15, 21, 38, 0.25);
    font-size: 14px;
    overflow: hidden;
}

.ts-dropdown .ts-dropdown-content { max-height: 260px; }

.ts-dropdown .option { padding: 10px 14px; }

.ts-dropdown .option.active {
    background: var(--orange-tint, #E7ECF1);
    color: var(--ink, #171B2C);
}
   .req{ color:#BF0001; }
</style>

@endsection