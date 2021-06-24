<template>
  <div>
    <form @submit.prevent="submit_form">
      <label for="title">Post title</label> <br />
      <input
        type="text"
        v-model="fields.title"
        class="form-control"
        id="title"
      />
      <!-- <div class="alert alert-danger" v-if="errors && errors.title">
        {{ errors.title[0] }}
      </div> -->
      <br />
      <label for="text">Post text</label> <br />
      <textarea
        rows="10"
        v-model="fields.post_text"
        class="form-control"
        id="text"
      ></textarea>
      <div class="alert alert-danger" v-if="errors && errors.post_text">
        {{ errors.post_text[0] }}
      </div>
      <br />
      <label for="category">Category</label> <br />
      <select v-model="fields.category_id" class="form-control" id="category">
        <option
          v-for="category in categories"
          :value="category.id"
          :key="category.id"
        >
          {{ category.name }}
        </option>
      </select>
      <br />
      <label for="category">Thumbnail</label> <br />
      <input type="file" @change="select_file" /> <br />
      <div class="alert alert-danger" v-if="errors && errors.category_id">
        {{ errors.category_id[0] }}
      </div>
      <br />
      <input
        type="submit"
        class="btn btn-primary"
        :value="form_submitting ? 'Saving post' : 'Save post'"
        :disabled="form_submitting"
      />
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      categories: [],
      fields: {
        title: "",
        post_text: "",
        category_id: "",
        thumbnail: null
      },
      errors: {},
      form_submitting: false
    };
  },

  mounted() {
    axios.get("/api/categories").then(response => {
      this.categories = response.data.data;
    });
  },

  methods: {
    select_file(event) {
      this.fields.thumbnail = event.target.files[0];
    },

    submit_form() {
      this.form_submitting = true;

      let fields = new FormData();
      for (let key in this.fields) {
        fields.append(key, this.fields[key]);
      }

      axios
        .post("/api/posts", fields)
        .then(response => {
          this.$router.push("/");
          this.form_submitting = false;
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }
          this.form_submitting = false;
        });
    }
  }
};
</script>
