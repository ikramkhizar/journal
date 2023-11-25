<script setup>
import { ref, watch } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { router } from '@inertiajs/vue3'
import debounce from 'lodash/debounce'

const props = defineProps({
  goals: Object,
  filters: Object
})

let search = ref(props.filters.search)

watch(
  search,
  debounce(function (value) {
    router.get(
      route('user.goals.index'),
      { search: value },
      {
        preserveState: true,
        replace: true
      }
    )
  }, 300)
)

// watch(search, value => {
//   router.get(
//     route('user.goals.index'),
//     { search: value },
//     {
//       preserveState: true,
//       replace: true
//     }
//   )
// })

// const filteredData = ref(props.goals.data)

// const escapeRegExp = value => {
//   return value.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&")
// }

// const handleGoalSearch = searchValue => {
//   // console.log(searchValue)

//   // console.log("coming")
//   // const filterGoals = props.goal.filter((item) => item.)

//   // setSearchText()

//   const searchRegex = new RegExp(escapeRegExp(searchValue), "i")

//   if (searchValue.length) {
//     const filteredRows = props.goals.data.filter(row => {
//       return searchRegex.test(row["name"].toString())
//     })

//     filteredData.value = filteredRows
//   } else {
//     filteredData.value = props.goals.data
//   }
// }

const destroy = id => {
  if (confirm('Are you sure?')) {
    router.delete(route('user.goals.destroy', id), {
      onSuccess: () => {},
      onError: error => {
        console.error(error)
      }
    })
  }
}
</script>

<template>
  <Head title="Goals" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Goals</h2>
    </template>

    <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-between items-center">
          <div>
            <input
              class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1"
              type="text"
              placeholder="Search Goal"
              v-model="search"
            />
            <!-- @keyup="handleGoalSearch($event.target.value)" -->
          </div>
          <Link
            :href="route('user.goals.create')"
            class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >Add Goal</Link
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Start Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th scope="col" class="relative px-6 py-3">
                          <span class="sr-only">Actions</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="goal in goals.data" :key="goal.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ goal.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{ goal.description ? goal.description.slice(0, 50) + '...' : '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ goal.start_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ goal.due_date }}</td>
                        <td class="px-6">
                          <Link
                            :href="route('user.goals.edit', goal.id)"
                            class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white"
                            >Edit</Link
                          >
                          <button
                            @click="destroy(goal.id)"
                            type="button"
                            class="ms-2 inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-sm text-white"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Pagination :links="goals.links" class="mt-5 mb-1 flex justify-center" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
