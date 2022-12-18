<template>
    <v-main class="list">
        <v-card>
            <v-list-item>
                <v-list-item-avatar color="grey"><img src="@/assets/logo.png" alt=""></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline">To Do List</v-list-item-title>
                    <v-list-item-subtitle>by 200710659</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-card-title>
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" outlined hidde details
                    style="margin-top: 30px">
                </v-text-field>
                <v-spacer></v-spacer>
                <v-btn color="success" dark @click="dialog = true"> Tambah </v-btn>
            </v-card-title>
        </v-card>
        <v-card>
            <v-data-table :headers="headers" :items="todos" :search="search" :single-expand="false"
                :expanded.sync="expanded" item-key="task" show-expand>
                <template v-slot:expanded-item="{ headers, item }">
                    <td :colspan="headers.length">
                        <v-card class="mt-5 mb-5" tile :color="item.color">
                            <v-chip class="mt-3 ms-3 mb-3 outlined" :color="item.colorChip" text-color="white">
                                <v-icon left>mdi-fire</v-icon>
                                {{ item.priority }}
                            </v-chip>
                            <v-spacer></v-spacer>
                            <v-chip class="ms-3 mb-3" color="orange" text-color="white">
                                <v-icon left>mdi-note</v-icon>
                                Note task: {{ item.note }}
                            </v-chip>
                        </v-card>
                    </td>
                </template>
                <template v-slot:[`item.priority`]="{ item }">
                    <v-icon :color="item.color" @click="priorityAlert(item)">mdi-alert-octagon</v-icon>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <span v-if="item.status == 'Selesai'">
                        <v-btn small color="success" class="me-3" fab outlined @click="editItem(item)" disabled>
                            <v-icon>mdi-pencil</v-icon> </v-btn>
                    </span>
                    <span v-else>
                        <v-btn small color="success" class="me-3" fab outlined @click="editItem(item)">
                            <v-icon>mdi-pencil</v-icon> </v-btn>
                    </span>
                    <v-btn small color="red" fab outlined @click="deleteItem(item)"> <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
                <v-card-title class="text-h5">Are you sure to delete?</v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="success darken-1" text @click="deleteItemConfirm">Yes</v-btn>
                    <v-btn color="red darken-1" text @click="closeDelete">No</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialog" persistent max-width="600px">
            <!-- v-dialog cuma bisa ilang waktu klik btn cancel aja (klik dimana aja g bakal ilang) itu fungsi dari persistent-->
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }} </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field v-model="formTodo.task" label="Task" required>
                        </v-text-field>
                        <v-select v-model="formTodo.priority" :items="[`Urgent`, `Normal`, `Not Important`]"
                            label="Priority" required>
                        </v-select>
                        <v-textarea v-model="formTodo.note" label="Note" required>
                        </v-textarea>
                        <v-select v-model="formTodo.status" :items="[`Selesai`, `Belum Selesai`]" label="Status"
                            required>
                        </v-select>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <span v-if="toAlert.priority == 'Urgent'">
            <v-snackbar v-model="alertPriority" :timeout="timeout" shaped dense :color="toAlert.color" top class="mt-3">
                <v-icon left> {{ toAlert.icon }}</v-icon>
                Notes Priority : {{ toAlert.priority }}
            </v-snackbar>
        </span>
        <span v-if="toAlert.priority == 'Not Important'">
            <v-snackbar v-model="alertPriority" :timeout="timeout" shaped dense :color="toAlert.color" right botttom
                class="mb-3 me-3">
                <v-icon left> {{ toAlert.icon }}</v-icon>
                Notes Priority : {{ toAlert.priority }}
            </v-snackbar>
        </span>
        <span v-if="toAlert.priority == 'Normal'">
            <v-snackbar v-model="alertPriority" :timeout="timeout" shaped dense :color="toAlert.color" left top
                class="mt-3 ms-3">
                <v-icon left> {{ toAlert.icon }}</v-icon>
                Notes Priority : {{ toAlert.priority }}
            </v-snackbar>
        </span>
    </v-main>
</template>

<script>
/* eslint-disable */
export default {
    name: "ListItem",
    data() {
        return {
            search: null,
            dialog: false,
            dialogDelete: false,
            statusSelesai: false,
            alertPriority: false,
            timeout: 3000,
            expanded: [],
            editedIndex: -1,
            headers: [
                {
                    text: "Task",
                    align: "start",
                    sortable: true,
                    value: "task",
                },
                { text: "Priority", value: "priority" },
                // { text: "Note", value: "note"},
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions" },
            ],
            todos: [
                {
                    task: "Coding",
                    priority: "Urgent",
                    note: "Code for your life!",
                    status: "Belum Selesai",
                    color: "red darken-1",
                    colorChip: "red lighten-1",
                },
                {
                    task: "Cooking",
                    priority: "Normal",
                    note: "Indomie saat begadang ngerjain coding terbaik",
                    status: "Selesai",
                    color: "yellow darken-1",
                    colorChip: "yellow lighten-1",
                },
                {
                    task: "Gaming",
                    priority: "Not Important",
                    note: "Game for your life!",
                    status: "Belum Selesai",
                    color: "blue darken-1",
                    colorChip: "blue lighten-1",
                },
            ],
            formTodo: {
                task: null,
                priority: null,
                note: null,
                status: null,
                color: null,
                colorChip: null,
            },
            toAlert: {
                priority: null,
                color: null,
                icon: null,
            }
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Item Form Todo List' : 'Edit Item Form Todo List'
        },
    },
    methods: {
        save() {
            if (this.formTodo.priority == 'Urgent') {
                this.formTodo.color = "red darken-1";
                this.formTodo.colorChip = "red lighten-1";
            } else if (this.formTodo.priority == 'Not Important') {
                this.formTodo.color = "blue darken-1";
                this.formTodo.colorChip = "blue lighten-1";
            } else if (this.formTodo.priority == 'Normal') {
                this.formTodo.color = "yellow darken-1";
                this.formTodo.colorChip = "yellow lighten-1";
            }
            if (this.editedIndex > -1) {
                Object.assign(this.todos[this.editedIndex], this.formTodo)
                this.editedIndex = -1;
            } else {
                this.todos.push(this.formTodo);
            }
            this.resetForm();
            this.dialog = false;
        },
        cancel() {
            this.editedIndex = -1;
            this.resetForm();
            this.dialog = false;
        },
        resetForm() {
            this.formTodo = {
                task: null,
                priority: null,
                note: null,
                status: null,
                color: null,
                colorChip: null,
            };
        },
        editItem(item) {
            this.editedIndex = this.todos.indexOf(item);
            this.formTodo = Object.assign({}, item);
            this.dialog = true;
        },
        deleteItem(item) {
            this.editedIndex = this.todos.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },
        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            })
        },
        deleteItemConfirm() {
            this.todos.splice(this.editedIndex, 1);
            this.closeDelete();
        },
        priorityAlert(item) {
            this.toAlert = Object.assign({}, item);
            if (this.toAlert.priority == 'Urgent') {
                this.toAlert.icon = "mdi-alarm-light"
            } else if (this.toAlert.priority == 'Not Important') {
                this.toAlert.icon = "mdi-heart"
            } else if (this.toAlert.priority == 'Normal') {
                this.toAlert.icon = "mdi-pause"
            }
            this.alertPriority = true;
        }
    },
};
</script>
<style>
.text {
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    font-size: 40px;
    font-style: italic;
}
</style>