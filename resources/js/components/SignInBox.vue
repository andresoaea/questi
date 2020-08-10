<template>
  <div class="answer-form-container">
    <div class="user-placeholder">
      <img :src="'user-placeholder.svg' | setImageSrc" />
    </div>

    <div class="data-input not-authenticated">
      <p v-if="scope === 'answer'">You must be logged in to post an answer</p>
      <p v-else>You must be logged in to ask a question</p>
      <div class="row">
        <div class="col regular-login">
          <a href="#" @click.prevent="showLogin">Login to your account</a>
          <a :href="`${siteUrl}/register`">Register</a>
        </div>
        <div class="col social-login">
          <a :href="`${siteUrl}/facebook-login`">
            <div>
              <i class="fa fa-facebook-square" aria-hidden="true"></i> Login with Facebook
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</template>

<script>
import { bus } from "../main";

export default {
  data() {
    return {
      siteUrl
    };
  },
  props: ["scope"],
  methods: {
    showLogin: function() {
      $("html,body").animate({ scrollTop: 0 }, "slow");
      bus.$emit("showLogin", true);
    }
  }
};
</script>