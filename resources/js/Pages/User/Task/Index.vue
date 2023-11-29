<script setup>
import { ref, watch } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { router } from '@inertiajs/vue3'
import debounce from 'lodash/debounce'

const props = defineProps({
  tasks: Object,
  filters: Object
})

let search = ref(props.filters.search)

watch(
  search,
  debounce(function (value) {
    router.get(
      route('user.tasks.index'),
      { search: value },
      {
        preserveState: true,
        replace: true
      }
    )
  }, 300)
)

const destroy = id => {
  if (confirm('Are you sure?')) {
    router.delete(route('user.tasks.destroy', id), {
      onSuccess: () => {},
      onError: error => {
        console.error(error)
      }
    })
  }
}
</script>

<template>
  <Head title="Tasks" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks</h2>
    </template>

    <div class="py-8">
      <div class="max-w-7xl mx-auto">
        <div class="mb-4 flex justify-between items-center">
          <div>
            <input
              class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1"
              type="text"
              placeholder="Search Task"
              v-model="search"
            />
          </div>
          <Link
            :href="route('user.tasks.create')"
            class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >Add Task</Link
          >
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="min-w-full border divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Goal Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Target Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Task Name
                        </th>
                        <!-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Description
                        </th> -->
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="relative px-6 py-3">
                          <span class="sr-only">Actions</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="task in tasks.data" :key="task.id" v-if="tasks.total > 0">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.goal_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.target_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.name }}</td>
                        <!-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.description }}</td> -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          <span
                            class="rounded-md px-2 py-1 text-white"
                            :class="{
                              'bg-amber-500': task.priority == 'low',
                              'bg-cyan-500': task.priority == 'medium',
                              'bg-red-600': task.priority == 'high'
                            }"
                          >
                            {{ task.priority_label }}
                          </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.status_label }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ task.due_date }}</td>
                        <td class="px-6">
                          <Link
                            :href="route('user.tasks.edit', task.id)"
                            class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white"
                            >Edit</Link
                          >
                          <button
                            @click="destroy(task.id)"
                            type="button"
                            class="ms-2 inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-sm text-white"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                      <tr v-else>
                        <td colspan="8" class="text-center py-3">No tasks found.</td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination v-if="tasks.total > tasks.per_page" :links="tasks.links" class="mt-5 mb-1 flex justify-center" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
