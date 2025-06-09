<script setup>
import { Head, Link } from '@inertiajs/vue3';
import IyataLayout from '@/Layouts/IyataLayout.vue';
import { reactive, ref, onMounted } from 'vue';

const tasks = ref([]);
const allTasks = ref([]);

const filters = reactive({
    estado: '',
    prioridad: '',
    titulo: ''
});

onMounted(async () => {
    getTasks();
});

async function getTasks(){
    let response = await axios.get('/api/task');

    console.log(response.data.tasks);

    let respTasks = response.data.tasks;

    respTasks = respTasks.map(task => {
        task.badge_priority = getBadgePriority(task.prioridad);
        task.badge_status = getBadgeStatus(task.estado);

        return task;
    });

    allTasks.value = respTasks;

    filterTasks();

    // tasks.value = respTasks;

    // console.log(tasks.value);
}

function filterTasks() {

    let filteredTasks = allTasks.value.filter(task => {

        if(filters.estado.length > 0){
            if(task.estado !== filters.estado) {
                return false;
            }
        }

        if(filters.prioridad.length > 0){
            if(task.prioridad !== filters.prioridad) {
                return false;
            }
        }

        if(filters.titulo.length > 0){
            if(!task.titulo.toLowerCase().includes(filters.titulo.toLowerCase())) {
                return false;
            }
        }

        return true;
    });

    tasks.value = filteredTasks;
    
    return true;
}

async function deleteTask(id) {
    let response = await axios.delete('/api/task/' + id);

    if(response.data.success) {
        getTasks();
    }
}

function getBadgePriority(priority) {
    switch (priority) {
        case 'ALTA':
            return 'badge-priority-high';
        case 'MEDIA':
            return 'badge-priority-medium';
        case 'BAJA':
            return 'badge-priority-low';
        default:
            return '';
    }
};

function getBadgeStatus(status) {
    switch (status) {
        case 'PENDIENTE':
            return 'badge-status-pending';
        case 'COMPLETADA':
            return 'badge-status-completed';
        default:
            return '';
    }
};

</script>

<template>

    <IyataLayout>
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">
                            <i class="fas fa-list me-2"></i>Mis Tareas
                        </h2>
                        <Link
                            href="/task/create"
                            class="btn btn-primary"
                            preserve-scroll
                        >
                            <i class="fas fa-plus me-1"></i>Nueva Tarea
                        </Link>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <select class="form-select" v-model="filters.estado" @change="filterTasks()">
                                <option value="">Todas las tareas</option>
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="COMPLETADA">Completadas</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" v-model="filters.prioridad" @change="filterTasks()">
                                <option value="">Todas las prioridades</option>
                                <option value="ALTA">Alta</option>
                                <option value="MEDIA">Media</option>
                                <option value="BAJA">Baja</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Buscar tareas..." v-model="filters.titulo" @input="filterTasks()">
                        </div>
                    </div>

                    <!-- Lista de Tareas -->
                    <div v-for="task in tasks" class="todo-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="todo-title">{{ task.titulo }}</div>
                                <div class="todo-description">{{ task.descripcion }}</div>
                                <div class="todo-meta">
                                    <span :class="'badge me-2 ' + getBadgePriority(task.prioridad)">{{ task.prioridad }}</span>
                                    <span :class="'badge me-2 ' + getBadgeStatus(task.estado)">{{ task.estado }}</span>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i>
                                </button>
                                <Link
                                    :href="'/task/edit/' + task.id"
                                    class="btn btn-warning btn-sm"
                                    preserve-scroll
                                    preserve-state
                                >
                                    <i class="fas fa-edit"></i>
                                </Link>
                                <button class="btn btn-danger btn-sm" @click="deleteTask(task.id)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </IyataLayout>
</template>