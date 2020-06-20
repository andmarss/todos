<template>
    <li class="d-flex align-items-center list-group-item"
        v-if="Object.keys(todo).length > 0"
    >
        <div>
            <button class="btn border-0 flex-grow-1 text-left"
                    :class="[todo.completed ? 'completed' : '']"
                    v-if="!editing"
                    @click="$emit('complete', todo)"
            >
                {{todo.text}}
            </button>
            <form class="flex-grow-1 d-inline-block" @submit.prevent="updateTodo" v-else>
                <input type="text" class="form-control" v-model="text" @blur="updateTodo" :id="`input-todo-${todo.id}`">
            </form>
            <button class="btn btn-outline-primary ml-1 border-0" @click.prevent="updateTodo">
                <i class="fa fa-edit"></i>
            </button>
            <div class="d-inline-block">
                <button class="btn btn-outline-primary ml-1 border-0" @click.prevent="$emit('complete', todo)">
                    <i class="fa" :class="[todo.completed ? 'fa-times' : 'fa-check']"></i>
                </button>
                <button class="btn btn-outline-primary ml-1 border-0" @click.prevent="$emit('urgent', todo)">
                    <i class="fa" :class="[todo.urgent ? 'fa-fire-extinguisher' : 'fa-fire']" aria-hidden="true"></i>
                </button>
                <button class="btn btn-outline-primary ml-1 border-0 text-danger" @click.prevent="$emit('delete',todo)">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        props: {
            todo: {
                type: Object,
                required: true
            }
        },
        data(){
            return {
                editing: false,
                text: ''
            }
        },
        methods: {
            updateTodo(){
                if (!this.editing) {
                    this.text = this.todo.text;
                    this.$nextTick(() => document.querySelector(`input-todo-${this.todo.id}`).focus());
                } else if (this.editing && this.text !== this.todo.text) {
                    this.$emit('update', this.todo, this.text);
                }

                this.editing = !this.editing;
            }
        }
    }
</script>

<style scoped>
    .completed {
        text-decoration: line-through !important;
    }
</style>