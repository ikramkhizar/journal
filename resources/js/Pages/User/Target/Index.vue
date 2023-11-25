<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import { router } from "@inertiajs/vue3"

defineProps({
  targets: Object
})

const destroy = id => {
  if (confirm("Are you sure?")) {
    router.delete(route("user.targets.destroy", id), {
      onSuccess: () => {},
      onError: error => {
        console.error(error)
      }
    })
  }
}
</script>

<template>
  <Head title="Targets" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Targets</h2>
    </template>

    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-5">
          <Link
            :href="route('user.targets.create')"
            class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >Add Target</Link
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="relative px-6 py-3">
                          <span class="sr-only">Actions</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="target in targets" :key="target.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ target.goal.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ target.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ target.type_label }}</td>
                        <td class="px-6">
                          <Link
                            :href="route('user.targets.edit', target.id)"
                            class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white"
                            >Edit</Link
                          >
                          <button
                            @click="destroy(target.id)"
                            type="button"
                            class="ms-2 inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-sm text-white"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
