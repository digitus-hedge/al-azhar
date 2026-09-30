@extends('admin.layout')
@section('title', 'Fees')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Done!',
            text: @json(session('success')),
            confirmButtonColor: '#BF0001',
            timer: 2500,
            timerProgressBar: true
        });
    });
</script>
@endif

<div class="wrap">
    <div class="header">
        <div>
            <h1>Fees</h1>
            <p>Class-wise school fees. Each fee is paid in instalments; the yearly total is calculated automatically.</p>
        </div>
        <a href="{{ route('admin.fees.create') }}" class="btn-add">
            <i class="bi bi-plus-lg"></i> Add Fee
        </a>
    </div>

    <div class="card">
        {{-- Toolbar --}}
        <form method="GET" action="{{ route('admin.fees') }}" class="toolbar">
            <div class="search-box">
                <i class="bi bi-search"></i>
             <input type="text" name="search" id="feeSearch" value="{{ $search }}"
       placeholder="Search class..." autocomplete="off">
                @if ($search)
                    <a href="{{ route('admin.fees', ['per_page' => $perPage]) }}" class="search-clear" title="Clear">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>

            <div class="per-page">
                <span>Show</span>
                <select name="per_page" onchange="this.form.submit()">
                    @foreach ([10, 25, 50, 100] as $n)
                        <option value="{{ $n }}" {{ (int) $perPage === $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Class</th>
                        <th>School Fees</th>
                        <th>Total</th>
                   
                        <th style="width:120px;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fees as $fee)
                    <tr>
                        <td class="muted">{{ $fees->firstItem() + $loop->index }}</td>
                        <td><b>{{ $fee->class_name }}</b></td>
                        <td>₹{{ number_format($fee->fee_amount, 2) }} <span class="muted">× {{ $fee->installments }}</span></td>
                        <td class="total">₹{{ number_format($fee->total_amount, 2) }}</td>
                      
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.fees.edit', $fee->id) }}" class="act-btn" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                               <form action="{{ route('admin.fees.destroy', $fee->id) }}" method="POST" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="act-btn act-delete" title="Delete"
            data-name="{{ $fee->class_name }}"
            onclick="confirmDelete(this)">
        <i class="bi bi-trash3"></i>
    </button>
</form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty">
                                <i class="bi bi-cash-coin"></i>
                                <p>{{ $search ? 'No fees match your search.' : 'No fees added yet.' }}</p>
                                @unless ($search)
                                    <a href="{{ route('admin.fees.create') }}" class="btn-add">
                                        <i class="bi bi-plus-lg"></i> Add your first fee
                                    </a>
                                @endunless
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($fees->hasPages())
            <div class="pager">
                <span class="muted">Showing {{ $fees->firstItem() }}–{{ $fees->lastItem() }} of {{ $fees->total() }}</span>
                {{ $fees->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(btn) {
    const name = btn.dataset.name;

    Swal.fire({
        icon: 'warning',
        title: 'Delete fee?',
        text: `The fee for "${name}" will be permanently deleted.`,
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#002F5F',
        cancelButtonColor: '#9AA1B2'
    }).then(result => {
        if (result.isConfirmed) btn.closest('form').submit();
    });
}

(function () {
    const input = document.getElementById('feeSearch');
    if (!input) return;

    let timer;

    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(() => {
            input.form.submit();
        }, 500); // waits 0.5s after typing stops
    });

    // After the page reloads, keep the cursor in the box at the end of the text
    if (input.value) {
        input.focus();
        const len = input.value.length;
        input.setSelectionRange(len, len);
    }
})();

</script>
<style>
    .header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:28px; gap:16px; flex-wrap:wrap; }
    .header h1{ font-size:25px; font-weight:700; letter-spacing:-0.02em; margin:0; color: var(--ink,#171B2C); }
    .header p{ font-size:13.5px; color: var(--muted,#667085); margin:7px 0 0; line-height:1.55; }

    .btn-add{
        display:inline-flex; align-items:center; gap:6px; padding:10px 18px; font-size:13px; font-weight:600;
        color:#fff; background: var(--orange,#BF0001); border-radius:9px; text-decoration:none;
        transition:transform .12s, box-shadow .12s; white-space:nowrap;
        /* box-shadow:0 4px 12px -4px rgba(191,0,1,0.4); */
    }
    .btn-add:hover{ transform:translateY(-1px); color:#fff; }

    .toolbar{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px; flex-wrap:wrap; }
    .search-box{ position:relative; flex:1; max-width:340px; }
    .search-box > i{ position:absolute; left:13px; top:50%; transform:translateY(-50%); color: var(--faint,#9AA1B2); font-size:14px; }
    .search-box input{
        width:100%; border:1px solid var(--input-border,#DBDFEA); border-radius:10px;
        padding:10px 36px 10px 36px; font-size:13.5px; font-family:inherit; outline:none; box-sizing:border-box;
    }
    .search-box input:focus{ border-color: var(--orange,#BF0001); box-shadow:0 0 0 4px var(--orange-tint-strong,#FFE9D8); }
    .search-clear{ position:absolute; right:12px; top:50%; transform:translateY(-50%); color: var(--faint,#9AA1B2); font-size:12px; }
    .per-page{ display:flex; align-items:center; gap:8px; font-size:13px; color: var(--muted,#667085); }
    .per-page select{ border:1px solid var(--input-border,#DBDFEA); border-radius:8px; padding:7px 10px; font-size:13px; font-family:inherit; outline:none; cursor:pointer; }

    .table-wrap{ overflow-x:auto; }
    .data-table{ width:100%; border-collapse:collapse; font-size:13.5px; }
    .data-table th{
        text-align:left; font-size:11.5px; font-weight:700; text-transform:uppercase; letter-spacing:.04em;
        color: var(--faint,#9AA1B2); padding:12px 14px; border-bottom:1px solid var(--line,#E9EBF2); white-space:nowrap;
    }
    .data-table td{ padding:14px; border-bottom:1px solid var(--line,#E9EBF2); color: var(--ink,#171B2C); vertical-align:middle; }
    .data-table tbody tr:hover{ background: var(--canvas,#F6F7FB); }
    .data-table .total{ font-weight:700; color: var(--orange,#BF0001); }
    .muted{ color: var(--faint,#9AA1B2); }

    .badge{ display:inline-block; font-size:11.5px; font-weight:600; padding:3px 10px; border-radius:999px; }
    .badge-on{ background:#E7F6EC; color:#1E8E4E; }
    .badge-off{ background:#F1F2F6; color:#667085; }

    .actions{ display:flex; justify-content:flex-end; gap:6px; }
    .actions form{ margin:0; }
    .act-btn{
        width:32px; height:32px; border-radius:8px; border:1px solid var(--line,#E9EBF2); background:#fff;
        color: var(--muted,#667085); display:inline-flex; align-items:center; justify-content:center;
        cursor:pointer; text-decoration:none; transition:all .15s; font-size:13px;
    }
    .act-btn:hover{ color: var(--orange,#BF0001); border-color: var(--orange-border,#F3D8C2); background: var(--orange-tint,#FFF8F3); }
    .act-delete:hover{ color:#C62828; border-color:#F3C4C4; background:#FFF6F6; }

    .empty{ text-align:center; padding:40px 12px; }
    .empty > i{ font-size:34px; color: var(--faint,#9AA1B2); }
    .empty p{ font-size:13.5px; color: var(--muted,#667085); margin:10px 0 16px; }

    .pager{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:16px; flex-wrap:wrap; font-size:13px; }
</style>

@endsection