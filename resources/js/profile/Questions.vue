<template>
  <div>
    <header class="section-title">
      <p class="float-left">{{ user.firstname }}'s questions</p>
      <span class="float-right">Total: {{ getProperty('questionsCount') }}</span>
      <div class="clearfix"></div>
      <hr class="cleared" />
    </header>

    <table v-if="getProperty('questionsCount') !== 0" class="table user-data-table">
      <tbody>
        <tr>
          <th>Question</th>
          <th>Date</th>
          <th style="width: 40px">Answers</th>
          <th>Status</th>
          <th>Action</th>
        </tr>

        <tr v-for="question in questionsData.data">
          <td>
            <a :href="questionLink(question.slug, question.category_slug)" target="_blank">
              <i aria-hidden="true" class="fa fa-question"></i>
              {{ question.title }}
            </a>
          </td>
          <td>{{ question.created_at | relativeTime('D MMM YYYY') }}</td>
          <td>
            <span :class="['badge', question.answers_count > 0 ? 'bg-success' : 'bg-warning']">
              {{ question.answers_count }}
              <i aria-hidden="true" class="fa fa-reply"></i>
            </span>
          </td>
          <td v-if="question.best_answer">
            <p class="text-success">
              <i class="fa fa-check-circle-o" aria-hidden="true"></i> Solved
            </p>
          </td>
          <td v-else>
            <p class="text-danger">
              <i class="fa fa-check" aria-hidden="true"></i> In progress
            </p>
          </td>
          <td>
            <a :href="questionLink(question.slug, question.category_slug)" target="_blank">
              <button type="button" class="btn btn-outline-primary btn-sm">View / Edit</button>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <small v-else>No questions yet</small>

    <pagination
      class="float-right"
      :limit="2"
      :data="questionsData"
      @pagination-change-page="getResults"
    ></pagination>

    <div class="clearfix"></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      questionsData: {}
    };
  },
  computed: {
    user() {
      return this.getProperty("user");
    }
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getProperty(property) {
      return this.$store.state[property];
    },
    getResults(page = 1) {
      axios
        .get(siteUrl + "/api/profile/data/questions?page=" + page)
        .then(response => {
          this.questionsData = response.data;
        });
    },
    questionLink(slug, categorySlug) {
      return siteUrl + "/" + categorySlug + "/" + slug;
    }
  }
  // created() {
  // 	axios.get(siteUrl + '/api/profile/data/questions?page=1')
  // 		.then((response) => {
  // 			this.questions = response.data.data
  // 		})
  // }
};
</script>