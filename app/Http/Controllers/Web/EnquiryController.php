<?php

namespace App\Http\Controllers\Web;

use App\Enquiries\Commands\SubmitEnquiryCommand;
use App\Enquiries\Commands\SubmitEnquiryHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnquiryRequest;
use App\Models\ProductEnquiry;
use App\Services\ProductCatalogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $catalog,
        private readonly SubmitEnquiryHandler $submitHandler,
    ) {}

    public function store(StoreEnquiryRequest $request, int $id): RedirectResponse
    {
        $product = $this->catalog->find($id);

        if ($product === null) {
            abort(404);
        }

        $enquiry = $this->submitHandler->handle(new SubmitEnquiryCommand(
            productId: $id,
            name: $request->validated('name'),
            email: $request->validated('email'),
            phone: $request->validated('phone'),
            message: $request->validated('message'),
            productTitle: $product->title,
        ));

        return redirect()
            ->route('enquiries.thank-you', ['reference' => $enquiry->reference])
            ->with('success', true);
    }

    public function thankYou(string $reference): View
    {
        $enquiry = ProductEnquiry::query()->where('reference', $reference)->firstOrFail();

        return view('enquiries.thank-you', [
            'enquiry' => $enquiry,
            'categories' => $this->catalog->categories(),
        ]);
    }
}
