<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use URL;
use Auth;
use Illuminate\Support\Facades\File;
use App\Http\Resources\ListingResource;
use App\Http\Resources\LegalDocumentsResource;
use App\Http\Resources\ContractResource;
use App\Http\Resources\ProposalsResource;
use App\Models\Proposals;

class ContractDetailResource extends JsonResource
{
    /**s
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {              
        //$document = URL::to('/') . Storage::disk('local')->url('public/ListingDocuments/' .$this->listing_id . '/' . $this->user_type . '/' . $this->legal_document_path);
        
        $proposal = Proposals::where('listing_id', $this->getListing->id)
                             ->where('user_id', $this->getContract->contractor_id)
                             ->where('status', 'pre_contract')->first();

        return [
            'listing'=> new ListingResource($this->getListing),
            'contract'=> new ContractResource($this->getContract),
            'proposal'=> new ProposalsResource($proposal),
            'legal_client_documents'=> LegalDocumentsResource::collection($this->getLegalClientDocuments),
            'legal_contractor_documents'=> LegalDocumentsResource::collection($this->getLegalContractorDocuments),
            'finance_client_documents'=> LegalDocumentsResource::collection($this->getFinanceClientDocuments),
            'finance_contractor_documents'=> LegalDocumentsResource::collection($this->getFinanceContractorDocuments),            
            'legal_client_total_percentage'=> $this->getLegalClientDocuments->sum('percentage'),
            'legal_contractor_total_percentage'=> $this->getLegalContractorDocuments->sum('percentage'),
            'finance_client_total_percentage'=> $this->getFinanceClientDocuments->sum('percentage'),
            'finance_contractor_total_percentage'=> $this->getFinanceContractorDocuments->sum('percentage'),
            'legal_client_last_update_on'=> $this->getLegalClientDocuments->max('created_at'),
            'legal_contractor_last_update_on'=> $this->getLegalContractorDocuments->max('created_at'),
            'finance_client_last_update_on'=> $this->getFinanceClientDocuments->max('created_at'),
            'finance_contractor_last_update_on'=> $this->getFinanceContractorDocuments->max('created_at'),
        ];
    }
}
