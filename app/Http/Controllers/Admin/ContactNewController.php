<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Contact Messages — read-only list: name, email, phone, subject, message.
 */
class ContactNewController extends Controller
{
    protected array $sortable = ['name', 'email', 'phone', 'subject', 'created_at'];

    protected array $perPageOptions = [10, 25, 50, 100];

    public function index(Request $request): View
    {
        $search  = trim((string) $request->query('q', ''));
        $sortBy  = $request->query('sort', 'created_at');
        $sortDir = strtolower((string) $request->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $perPage = (int) $request->query('per_page', 10);

        if (! in_array($sortBy, $this->sortable, true)) {
            $sortBy = 'created_at';
        }
        if (! in_array($perPage, $this->perPageOptions, true)) {
            $perPage = 10;
        }

        $contacts = Contact::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDir)
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.contacts.index', [
            'contacts'       => $contacts,
            'search'         => $search,
            'sortBy'         => $sortBy,
            'sortDir'        => $sortDir,
            'perPage'        => $perPage,
            'perPageOptions' => $this->perPageOptions,
        ]);
    }
}
