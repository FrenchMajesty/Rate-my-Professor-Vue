<template>
	<form 
		@submit.preventDefault="submit"
		@keydown="clearFieldErrors"
	>
		<slot></slot>
	</form>
</template>

<script>
	export default {
		name: 'SmartForm',
		props: {
			/**
			 * The form object of the form to submit
			 * @type {Object}
			 */
			form: {
				type: Object,
				required: true,
			},

			/**
			 * The method to trigger on submit
			 * @type {Object}
			 */
			submit: {
				type: Function,
				required: true,
			},
		},
		methods: {
			/**
			 * On keyDown, clear the errors on the target input
			 * @param  {HTMLElement} event.target The target input's HTML element
			 * @return {Void}                 
			 */
			clearFieldErrors({target}) {
				this.form.errors.clear(target.getAttribute('data-name'));
			},
		},
	}
</script>