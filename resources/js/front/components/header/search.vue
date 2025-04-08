<template>
    <div class="w-full  bg-gray-100 rounded-md shadow-xl  h-64">
        <div class="grid grid-cols-5 gap-8">
            <div class="md:col-span-1"></div>
            <div class="col-span-2">
                <input type="text" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg mt-8 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                    placeholder="search somthing here ...">
            </div>
            <div class="col-span-1">
                <button type="submit"
                    class="text-white  bg-blue-700 hover:bg-blue-800 w-48 mt-8 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">search</button>
            </div>
        </div>
</div></template>