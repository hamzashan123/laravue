<template>
  <div>
    <!-- Header -->
    <!-- <b-card> -->
    <b-row class="mb-4">
      <b-col md="6" sm="12">
        <b-card-text> <h1>New Listing</h1> </b-card-text>
      </b-col>
      <b-col md="6" sm="12">
        <div class="text-right">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            :to="{ name: 'listings.view' }"
          >
            Publish Listing
          </b-button>
        </div>
      </b-col>
    </b-row>
    <!-- </b-card> -->

    <!-- Date and amount Form -->
    <b-card>
      <b-form @submit.prevent>
        <b-row>
          <b-col md="6">
            <h4 class="mb-2 text-primary">
              <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
              Target Compilation date Range
            </h4>
            <b-form inline>
              <b-form-datepicker
                placeholder="From"
                id="from"
                class="mb-1 p-0"
              />
              <b-form-datepicker placeholder="To" id="to" class="mb-1 p-0" />
            </b-form>
          </b-col>
          <b-col md="6">
            <h4 class="mb-2 text-primary">
              <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
              Target Budget - Min and Max
            </h4>
            <b-form inline>
              <b-form-select v-model="minBudgetVal" :options="minBudget" class="mb-1" />
              <b-form-select v-model="maxBudgetVal" :options="maxBudget" class="mb-1" />
            </b-form>
          </b-col>
        </b-row>
      </b-form>
    </b-card>

    <!-- Images and Detail -->
    <b-card>
      <b-form @submit.prevent>
        <b-row>
          <!-- Images -->
          <b-col md="6" class="mb-2">
            <div class="d-flex flex-wrap mb-2">
              <b-img
                v-for="listingImage in listingImages"
                :key="listingImage.imageUrl"
                thumbnail
                class="w-25"
                :src="listingImage.imageUrl"
              />
            </div>
            <div class="d-flex align-items-end">
              <b-form-file
                placeholder="Add Pictures"
                drop-placeholder="Drop file here..."
                multiple
                accept=".jpg, .png,"
              />
            </div>
          </b-col>
          <!-- Details Form -->
          <b-col md="6" class="mb-2">
            <h4 class="mb-2">
              <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
              Listing Details ( Please enter as mush as possible )
            </h4>
            <b-form-group label="Name your listing" label-for="listingTitle">
              <b-form-input id="listingTitle" placeholder="Name" />
            </b-form-group>
            <div class="mb-2">
              <label for="listingDetails">Details</label>
              <b-form-textarea
                id="listingDetails"
                placeholder="Listing Details"
                rows="3"
              />
            </div>
            <b-row>
              <b-col lg="6" class="mb-2">
                <!-- <b-embed type="iframe" aspect="16by9" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen/> -->
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6999.66461408364!2d76.92634623988648!3d28.69466251428776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d096a6dcc31c7%3A0xbbcc18016f20e440!2sModicare%20Store!5e0!3m2!1sen!2s!4v1652653238809!5m2!1sen!2s"
                  width="100%"
                  height="300"
                  style="border: 0"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
              </b-col>
              <b-col lg="6">
                <b-form-group
                  label="Address Line 1 *"
                  label-for="address-line-1"
                >
                  <b-form-input
                    id="address-line-1"
                    placeholder="Address Line 1 *"
                    required
                  />
                </b-form-group>
                <b-form-group
                  label="Address Line 2 *"
                  label-for="address-line-2"
                >
                  <b-form-input
                    id="address-line-2"
                    placeholder="Address Line 2 *"
                    required
                  />
                </b-form-group>
                <b-form-group
                  label="Country"
                  label-for="country"
                >
                  <b-form-input
                    id="country"
                    placeholder="Country"
                    required
                  />
                </b-form-group>
                <b-form-group
                  label="State"
                  label-for="state"
                >
                  <b-form-select
                    v-model="stateVal"
                    :options="state"
                    id="state"
                    />
                </b-form-group>
                <b-form-group
                  label="District"
                  label-for="district"
                >
                  <b-form-select
                    v-model="districtVal"
                    :options="district"
                    id="district"
                    />
                </b-form-group>
              </b-col>
            </b-row>
            <!-- Save -->
            <b-col class="text-right">
              <b-button
                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                type="submit"
                variant="primary"
              >
                Save Details
              </b-button>
            </b-col>
          </b-col>
        </b-row>
      </b-form>
    </b-card>
  </div>
</template>

<script>
import {
  BCard,
  BRow,
  BCol,
  BButton,
  BCardText,
  BLink,
  BFormGroup,
  BFormInput,
  BFormCheckbox,
  BFormDatepicker,
  BForm,
  BFormSelect,
  BImg,
  BFormFile,
  BFormTextarea,
  BEmbed,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

export default {
  data() {
    return {
      minBudgetVal: null,
      maxBudgetVal: null,
      stateVal: null,
      districtVal: null,
      minBudget: [
        { value: null, text: "Budget Minimum *" },
        { value: "100000", text: "1000,00" },
        { value: "1000000", text: "1000,000" },
      ],
      maxBudget: [
        { value: null, text: "Budget Maximum *" },
        { value: "100500", text: "1000,500" },
        { value: "10000400", text: "10000,1400" },
      ],
      state: [
        { value: null, text: "Select State" },
        { value: "state", text: "state 1" },
        { value: "state", text: "state 1" },
      ],
      district: [
        { value: null, text: "Select District" },
        { value: "state", text: "state 1" },
      ],
      listingImages: [
        {
          imageUrl:
            "https://images.unsplash.com/photo-1533929736458-ca588d08c8be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8bG9uZG9ufGVufDB8fDB8fA%3D%3D&w=1000&q=80",
        },
        {
          imageUrl:
            "https://images.unsplash.com/photo-1533929736458-ca588d08c8be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8bG9uZG9ufGVufDB8fDB8fA%3D%3D&w=1000&q=80",
        },
        {
          imageUrl:
            "https://images.unsplash.com/photo-1533929736458-ca588d08c8be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8bG9uZG9ufGVufDB8fDB8fA%3D%3D&w=1000&q=80",
        },
        {
          imageUrl:
            "https://media.istockphoto.com/photos/london-symbols-with-big-ben-double-decker-buses-and-red-phone-booth-picture-id1294454411?b=1&k=20&m=1294454411&s=170667a&w=0&h=UOVuoyqF8H9J3Q5u-HxrWQFRQVQnGgcoF_L8SVbhxQQ=",
        },
        {
          imageUrl:
            "https://images.unsplash.com/photo-1533929736458-ca588d08c8be?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8bG9uZG9ufGVufDB8fDB8fA%3D%3D&w=1000&q=80",
        },
        {
          imageUrl:
            "https://media.istockphoto.com/photos/skyscrapers-in-city-of-london-picture-id844050350?k=20&m=844050350&s=612x612&w=0&h=g9is0uhRESMFnHLfgICPpInOQd65YNF68OoFpbNuwUc=",
        },
      ],
    };
  },
  components: {
    BRow,
    BCol,
    BCard,
    BButton,
    BCardText,
    BLink,
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BFormDatepicker,
    BForm,
    BFormSelect,
    BImg,
    BFormFile,
    BFormTextarea,
    BEmbed,
  },
  directives: {
    Ripple,
  },
};
</script>

<style>
</style>
