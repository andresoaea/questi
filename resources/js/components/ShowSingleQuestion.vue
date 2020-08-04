<template>
  <div>
    <article class="question">
      <div class="user-image">
        <img src="https://cdn4.iconfinder.com/data/icons/green-shopper/1068/user.png" />
      </div>
      <div class="user-question">
        <header>
          <span class="badge badge-pill badge-warning">
            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
            &nbsp; {{ question.category }}
          </span>
        </header>

        <h1>{{ question.title }}</h1>
        <p class="question-description">{{ question.description }}</p>

        <answer-form></answer-form>

        <hr />

        <footer>
          <span v-if="question.best_answer" class="float-left solved">
            <i class="fa fa-check"></i> Solved
          </span>

          <reactions v-if="reactionsData !== null" :reactions-data="reactionsData"></reactions>

          <!--  <vue-goodshare></vue-goodshare> -->
        </footer>
      </div>
      <div class="clearfix"></div>
    </article>

    <show-single-answer></show-single-answer>
  </div>
</template>

<script>
import ShowSingleAnswer from "./ShowSingleAnswer";
import Reaction from "./subcomponents/Reaction.vue";
import AnswerForm from "./subcomponents/AnswerForm.vue";
// import VueGoodshare from "vue-goodshare";

export default {
  components: {
    reactions: Reaction,
    AnswerForm
    // VueGoodshare
  },
  data() {
    return {
      question: question,
      reactionsData: {}
    };
  },
  created() {
    axios
      .get(
        siteUrl +
          "/api/reaction/" +
          question.id +
          (currentUser ? "/" + currentUser.id : "")
      )
      .then(response => {
        this.reactionsData = response.data;
      });
  }
};
</script>