<template>
	<form 
		class="md-layout md-layout-item md-size-95 ml-auto mr-auto"
		@submit.preventDefault="continueReview"
	>
		<md-field class="md-layout-item md-size-70 md-xsmall-size-100">
	      	<label>Write your review:</label>
	     	<md-textarea 
	     		v-model="review"
	     		:placeholder="`Start typing your review of this ${profileType} here.`"
	     		:maxlength="maxlength"
	      		md-autogrow
	    	></md-textarea>
	    </md-field>
	    <md-button 
	    	class="md-raised md-accent md-layout-item"
	    	type="submit"
	    >Continue your review</md-button>
	</form>
</template>

<script>
	export default {
		name: 'QuickReview',
		props: {
			/**
			 * The trigger to call when the form is submitted
			 * @type {Object}
			 */
			submit: {
				type: Function,
				required: true,
			},

			/**
			 * The type of entity for which this review is written. Must be professor or school.
			 * @type {Object}
			 */
			profileType: {
				type: String,
				required: true,
			}
		},
		data() {
			return {
				/**
				 * The written review
				 * @type {String}
				 */
				review: '',

				/**
				 * The max length of the review
				 * @type {Number}
				 */
				maxlength: 350,
			};
		},
		methods: {
			/**
			 * Update the store and proceed to the next step to finish writing the review
			 * @return {Void} 
			 */
			continueReview() {
				this.$store.commit('writeQuickReview', this.review);
				this.submit();
			}
		},
	}
</script>