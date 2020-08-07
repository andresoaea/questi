<template>
  <div>
    <questions-nav-tabs></questions-nav-tabs>

    <div class="vld-parent questions-preloader">
      <loading :active.sync="isLoading" :is-full-page="false" color="#f08727"></loading>
    </div>

    <h4 v-if="searchQuery && questions.length > 0">Search results for: {{ searchQuery }}</h4>
    <h4 v-if="searchQuery && questions.length === 0">No results for: {{ searchQuery }}</h4>
    <h4 v-if="!searchQuery && questions.length === 0">No questions yet</h4>

    <article v-for="question in questions" class="question">
      <div class="user-image">
        <img
          v-if="authors[questionAuthorIds[question.id]]['picture']"
          :src="
                        authors[questionAuthorIds[question.id]]['picture']
                            | setImageSrc('profile')
                    "
        />
        <img v-else :src="'user-placeholder.svg' | setImageSrc" />
      </div>
      <div class="user-question">
        <header>
          <span class="badge badge-pill badge-success">
            <i class="fa fa-star-o" aria-hidden="true"></i>
            &nbsp;
            {{
            authors[questionAuthorIds[question.id]]["role"]
            | capitalize
            }}
          </span>
          <span class="badge badge-pill badge-warning badge-category">
            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
            &nbsp;
            {{
            categories[question.category]
            ? categories[question.category]["name"]
            : "Uncategorized"
            }}
          </span>
        </header>

        <h1>
          <a
            :href="
                            fullQuestionUrl(
                                categories[question.category]
                                    ? categories[question.category]['slug']
                                    : 'uncategorized',
                                question.slug
                            )
                        "
            rel="bookmark"
          >{{ question.title }}</a>
        </h1>
        <p class="question-description">{{ question.description }}</p>

        <hr />

        <footer>
          <span v-if="question.best_answer" class="float-left solved">
            <i class="fa fa-check"></i> Solved
          </span>

          <span v-tooltip:top="fullnameTooltip(question)" class="float-left">
            <i class="fa fa-user-o" aria-hidden="true"></i>
            &nbsp; {{ getAuthorName(question, "firstname") }}
          </span>

          <span v-tooltip:top="addedFullTime(question.created_at)" class="float-left">
            <i class="fa fa-calendar" aria-hidden="true"></i>
            &nbsp;
            {{ question.created_at | relativeTime("Do MMMM") }}
          </span>

          <span class="float-left">
            <i class="fa fa-comments-o" aria-hidden="true"></i>
            &nbsp; {{ question.answers_count }}
          </span>

          <a
            :href="
                            fullQuestionUrl(
                                categories[question.category]
                                    ? categories[question.category]['slug']
                                    : 'uncategorized',
                                question.slug
                            )
                        "
            rel="bookmark"
          >
            <span class="answer mr0 float-right">
              {{ answerText(question.answers_count) }}
              <i class="fa fa-share" aria-hidden="true"></i>
            </span>
          </a>
        </footer>
      </div>
      <div class="clearfix"></div>
    </article>
  </div>
</template>

<script>
import { bus } from "../main";
import QuestionsNavTabs from "./QuestionsNavTabs.vue";

// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  name: "ShowAllQuestions",
  components: {
    QuestionsNavTabs,
    Loading
  },
  data() {
    return {
      questions: {},
      questionAuthorIds: {},
      categories: {},
      authors: {},
      siteUrl: siteUrl,
      searchQuery: "",
      isLoading: false
    };
  },
  created() {
    let type = this.$route.path.replace("/", "");
    let url =
      this.$route.path === "/" ? "get-questions" : `get-questions?type=${type}`;

    this.isLoading = true;

    axios.get(url).then(response => {
      setTimeout(() => {
        this.isLoading = false;
        this.updateAllData(response.data);
      }, 600);
    });

    bus.$on("updateQuestions", data => {
      this.searchQuery = data.searchQuery;
      this.updateAllData(data.questionsData);
    });
  },
  methods: {
    fullQuestionUrl: function(category, slug) {
      return this.siteUrl + "/" + category + "/" + slug;
    },
    getAuthorName: function(question, which) {
      return this.authors[this.questionAuthorIds[question.id]][which];
    },
    fullnameTooltip: function(question) {
      return (
        "Asked by: " +
        this.getAuthorName(question, "firstname") +
        " " +
        (this.getAuthorName(question, "lastname") || "")
      );
    },
    addedFullTime: function(time) {
      return "Added on: " + this.$options.filters.relativeTime(time, "LLLL");
    },
    answerText: function(number) {
      return number === 0 ? "Answer first" : "Answer";
    },
    updateAllData: function(data) {
      if (data.questions) {
        this.questions = data.questions;
        this.questionAuthorIds = data.question_author_ids;
        this.categories = data.categories;
        this.authors = data.authors;
      } else {
        this.questions = [];
      }
    }
  }
};
</script>
