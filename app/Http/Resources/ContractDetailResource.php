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
        
        $proposal = Proposals::where('listing_id', $this->id)
                             ->where('user_id', $this->getContracts->contractor_id)
                             ->whereIn('status' , ['pre_contract','contract_started','contract_completed'])->first();

        $legal_total_percentage = round(($this->getLegalClientDocuments->sum('percentage') + $this->getLegalContractorDocuments->sum('percentage'))/2) ;
        $finance_total_percentage = round(($this->getFinanceClientDocuments->sum('percentage') + $this->getFinanceContractorDocuments->sum('percentage'))/2) ;
        
        return [
            'listing'=> new ListingResource($this),
            'contract'=> new ContractResource($this->getContracts),
            'proposal'=> new ProposalsResource($proposal) ? new ProposalsResource($proposal) : 'No proposal yet!',
            'legal_client_documents'=> LegalDocumentsResource::collection($this->getLegalClientDocuments),
            'legal_contractor_documents'=> LegalDocumentsResource::collection($this->getLegalContractorDocuments),
            'finance_client_documents'=> LegalDocumentsResource::collection($this->getFinanceClientDocuments),
            'finance_contractor_documents'=> LegalDocumentsResource::collection($this->getFinanceContractorDocuments),            
            'legal_client_total_percentage'=> $this->getLegalClientDocuments->sum('percentage'),
            'legal_contractor_total_percentage'=> $this->getLegalContractorDocuments->sum('percentage'),
            'finance_client_total_percentage'=> $this->getFinanceClientDocuments->sum('percentage'),
            'finance_contractor_total_percentage'=> $this->getFinanceContractorDocuments->sum('percentage'),
            'legal_client_last_update_on'=> $this->getLegalClientDocuments->max('created_at') ? $this->getLegalClientDocuments->max('created_at') : 'No last update',
            'legal_contractor_last_update_on'=> $this->getLegalContractorDocuments->max('created_at') ? $this->getLegalContractorDocuments->max('created_at') : 'No last update' ,
            'finance_client_last_update_on'=> $this->getFinanceClientDocuments->max('created_at') ? $this->getFinanceClientDocuments->max('created_at') : 'No last update' ,
            'finance_contractor_last_update_on'=> $this->getFinanceContractorDocuments->max('created_at') ? $this->getFinanceContractorDocuments->max('created_at') : 'No last update',
            'legal_total_percentage' => $legal_total_percentage,
            'finance_total_percentage' => $finance_total_percentage,
        ];
    }
}
