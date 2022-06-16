<template>
    <div>
        <b-form-group label="Address Line 1" label-for="address-line-1">
            <b-form-input
                v-model="listing.address_line1"
                id="address-line-1"
                placeholder="Address Line 1"
                disabled
            />
        </b-form-group>
        <b-form-group label="Address Line 2" label-for="address-line-2">
            <b-form-input
                v-model="listing.address_line2"
                id="address-line-2"
                placeholder="Address Line 2"
                disabled
            />
        </b-form-group>
        <b-form-group label="Country" label-for="country">
            <b-form-input
                id="country"
                placeholder="Country"
                v-model="listing.country"
                disabled
            />
        </b-form-group>
        <b-form-group label="State" label-for="state">
            <b-form-input
                placeholder="State"
                v-model="listing.state"
                id="state"
                disabled
            />
        </b-form-group>
        <b-form-group label="District" label-for="district">
            <b-form-input
                placeholder="District"
                v-model="listing.district"
                id="district"
                disabled
            />
        </b-form-group>
    </div>
</template>

<script>
import {
    BFormGroup,
    BFormInput,
    BFormTextarea,
} from "bootstrap-vue";

export default {
    props: ["listing"],
    components: {
        BFormGroup,
        BFormInput,
        BFormTextarea,
    },
};
</script>

<style></style>
