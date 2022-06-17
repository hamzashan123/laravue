<template>
    <b-row>
        <!-- <b-col lg="12" > -->
        <!-- <div class="text-right">
                <b-button
                v-if="can('update', 'listing') || can('update', 'all-listing')"
                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                variant="primary"
                :to="{ name: 'listings.edit', params: { listingId: id } }"
            >
                Edit
                </b-button>
            </div> -->
        <!-- </b-col> -->
        <b-col md="6">
            <h4 class="mb-2 text-primary">
                <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
                Target Compilation date Range
            </h4>

            <div class="form-row">
                <div class="col">
                    <b-form-input
                        v-model="listing.target_completion_datefrom"
                        id="target_completion_datefrom"
                        placeholder="From Date"
                        disabled
                    />
                </div>
                <div class="col">
                    <b-form-input
                        v-model="listing.target_completion_dateto"
                        id="target_completion_dateto"
                        placeholder="Date To"
                        disabled
                    />
                </div>
            </div>
        </b-col>
        <b-col md="6">
            <h4 class="mb-2 text-primary">
                <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
                Target Budget - Min and Max
            </h4>
            <div class="form-row">
                <div class="col">
                    <b-form-input
                        v-model="listing.min_budget"
                        id="min_budget"
                        placeholder="Minimum Budget"
                        disabled
                    />
                </div>
                <div class="col">
                    <b-form-input
                        v-model="listing.max_budget"
                        id="max_budget"
                        placeholder="Maximum Budget"
                        disabled
                    />
                </div>
            </div>
        </b-col>
    </b-row>
</template>

<script>
import { BRow, BCol, BFormGroup, BFormInput, BFormTextarea } from "bootstrap-vue";

export default {
    props: ["listing"],
    components: {
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BFormTextarea,
    },
};
</script>

<style></style>
