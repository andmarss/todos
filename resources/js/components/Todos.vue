<template>
    <div>
        <h1>Todo App</h1>

        <div class="row">
            <div class="col">
                <ul class="list-group" id="usual-todos">
                    <li class="list-group-item">
                        <h3>Todos ({{usualTodos.length}})</h3>
                    </li>
                    <todo v-for="todo in usualTodos"
                          :key="todo.id"
                          :todo="todo"
                    ></todo>
                </ul>
            </div>
            <div class="col">
                <ul class="list-group" id="urgent-todos">
                    <li class="list-group-item">
                        <h3>Urgent Todos <span :class="[urgentTodos.length >= 3 ? 'urgent' : '']">({{urgentTodos.length}})</span></h3>
                    </li>
                    <todo v-for="todo in urgentTodos"
                          :key="todo.id"
                          :todo="todo"
                    ></todo>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Methods from '../mixins/methods';
    import Todo from './Todo';

    export default {
        mixins: [Methods],

        props: {
            todos: {
                type: String,
                required: true,
                default: ''
            }
        },

        data(){
            return {
                todoList: [],
                usualTodos: [],
                urgentTodos: []
            }
        },

        methods: {
            updateLists(){
                if (this.todoList.length) {
                    this.usualTodos = this.todoList.filter(todo => !todo.urgent).sort(todo => todo.completed ? 1 : -1);
                    this.urgentTodos = this.todoList.filter(todo => todo.urgent).sort(todo => todo.completed ? 1 : -1);
                }
            }
        },

        mounted(){
            if (typeof this.todos === "string" && this.todos.length) {
                this.todoList = JSON.parse(this.todos);

                this.updateLists();
            } else {
                this.todoList = [];
            }
        },

        components: {
            todo: Todo
        }
    }
</script>

<style lang="scss" scoped>
    .urgent {
        color: orangered !important;
    }
</style>