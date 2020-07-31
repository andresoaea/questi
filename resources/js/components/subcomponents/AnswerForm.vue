<template>
  <div>
    <div v-if="currentUser">
      <form @submit.prevent="add" @keydown="form.onKeydown($event)">
        <div class="answer-form-container">
          <div class="user-placeholder">
            <img src="https://cdn4.iconfinder.com/data/icons/green-shopper/1068/user.png" />
          </div>

          <div class="form-group data-input">
            <label>Your answer:</label>
            <textarea
              v-model="form.text"
              type="text"
              name="text"
              class="form-control"
              :class="{ 'is-invalid': form.errors.has('text') }"
              placeholder="Type your answer here.."
            ></textarea>
            <has-error :form="form" field="text"></has-error>
          </div>
          <div class="clearfix"></div>

          <button :disabled="form.busy" type="submit" class="btn btn-primary float-right">Add Answer</button>
          <div class="clearfix"></div>
        </div>
      </form>
    </div>
    <div v-else>
      <div class="answer-form-container">
        <div class="user-placeholder">
          <img src="https://cdn4.iconfinder.com/data/icons/green-shopper/1068/user.png" />
        </div>

        <div class="data-input not-authenticated">
          <p>You need to be signed in to post an answer</p>
          <div class="row">
            <div class="col regular-login">
              <a href="#" @click.prevent="showLogin">Login to your account</a>
              <a href="../register">Register</a>
            </div>
            <div class="col social-login">
              <a href="../facebook-login">
                <div>
                  <i class="fa fa-facebook-square" aria-hidden="true"></i> Login with Facebook
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { bus } from "../../main";

export default {
  name: "answer-form",
  data() {
    return {
      form: new Form({
        text: "",
        for: this.$parent.question.id
      }),
      currentUser: currentUser
    };
  },
  methods: {
    add() {
      // Snow progress bar
      this.$Progress.start();

      // Submit the form via a POST request
      this.form
        .post(siteUrl + "/api/answer")
        .then(response => {
          // Hide progress bar
          this.$Progress.finish();
          this.form.text = "";

          // Show confirmation
          swal({
            position: "center",
            type: "success",
            html: "<h5>Your answer has been added</h5>",
            showConfirmButton: false,
            showCancelButton: false,
            timer: 1500
          });

          // Add the anwer to the answers list
          //console.log(data)
          // this.$parent.answers.push(response.data)
          bus.$emit("updateAnswersData", response.data.answer);
        })
        .catch(error => {
          this.$Progress.fail();

          if (error.response.status !== 422) {
            swal({
              position: "center",
              type: "error",
              html: `
						  	<h4>Oops. Something went wrong..</h4>
						  	<p>Your answer wasn't saved in our database.</p>
						  	<h5>Please try again later!</h5>
						  `,
              showConfirmButton: false,
              showCancelButton: true
            });
          }
        });
    },
    showLogin: function() {
      bus.$emit("showLogin", true);
    }
  }
};
</script>