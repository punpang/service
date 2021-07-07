<template>
  <v-text-field v-model="newTodo.title" @keyup.enter="addTodo"></v-text-field>
</template>
    <script>
import { mapGetters } from "vuex";
export default {
  name: "NewTodo",
  methods: {
    addTodo() {
      this.newTodo.id = this.$route.params.id;
      this.$store.dispatch("pusher/ADD_TODO", this.newTodo);
    },
  },
  computed: {
    ...mapGetters({ newTodo: "pusher/newTodo" }),
  },
};
</script>