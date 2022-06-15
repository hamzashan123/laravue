<template>
    <div>
        <h4 class="mb-2">
            <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
            {{ heading }}
        </h4>
        <b-form-group label="Name your listing" label-for="listingname">
            <b-form-input
                id="listingname"
                v-model="listing.title"
                placeholder="Name"
                disabled
            />
        </b-form-group>

        <div class="mb-2">
            <label for="listingDetails">Description</label>
            <b-form-textarea
                id="listingDetails"
                v-model="listing.description"
                placeholder="Listing Details"
                rows="3"
                disabled
            />
        </div>
    </div>
</template>

<script>
import {
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BFormTextarea,
} from "bootstrap-vue";

export default {
    props: ['heading', 'listing' ],
    components: {
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormTextarea,
    }
};
</script>

<style></style>
