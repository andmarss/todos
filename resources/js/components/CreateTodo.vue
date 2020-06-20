<template>
    <li class="d-flex align-items-center list-group-item" v-if="todo">
        <form @submit.prevent="createTodo" class="mr-1 w-75">
            <input
                    v-model="todo.text"
                    type="text"
                    class="form-control"
                    placeholder="Todo..."
            />
        </form>
        <button @click="createTodo" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </li>
</template>

<script>
    export default {
        data(){
            return {
                todo: null
            }
        },
        methods: {
            /**
             * Prepare todo by default
             */
            prepareTodo(){
                let site = window.site;

                this.todo = {
                    text: '',
                    completed: false,
                    urgent: false,
                    user_id: site.user.id
                };
            },
            /**
             * creating todo
             * if text.length === 0 - dont creating
             */
            createTodo(){
                if (!this.todo.text.length) return;

                this.$emit('create', this.todo);

                this.prepareTodo();
            }
        },
        mounted() {
            this.prepareTodo();
        }
    }
</script>