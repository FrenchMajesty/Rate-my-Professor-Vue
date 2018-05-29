<template>
	<div class="section-container">
		<span class="was-helpful" @click="reviewWasHelpful(true)">
			<md-button class="md-icon-button">
		    	<md-icon :class="{'selected-positive': didUserVote(true)}">thumb_up</md-icon>
		    </md-button>
			<span v-if="deviceIsAPhone">
				{{positiveVotes > 0 ? `+${positiveVotes}` : '0'}}
			</span>
			<span v-else>
				{{positiveVotes > 0 ? `${positiveVotes} people` : 'Nobody'}} found this helpful.
			</span>
		</span>
		<span class="not-helpful" @click="reviewWasHelpful(false)">
			<md-button class="md-icon-button">
		    	<md-icon :class="{'selected-negative': didUserVote(false)}">thumb_down</md-icon>
		    </md-button>
			<span v-if="deviceIsAPhone">
				{{negativeVotes > 0 ? `-${negativeVotes}` : '0'}}
			</span>
			<span v-else>
				{{negativeVotes > 0 ? `${negativeVotes} people` : 'Nobody'}} did not find this helpful.
			</span>
		</span>
	</div>
</template>

<script>
	import Fetcher from 'Js/lib/Fetcher';
	import { saveProfessorReviewFeedback } from 'Js/store/api';

	export default {
		name: 'ReviewFeedback',
		props: {
			/**
			 * The ID of the review for the feedback
			 * @type {Number}
			 */
			itemId: {
				type: Number,
				required: true,
			},

			/**
			 * The type of review on which this feedback is on
			 * @type {String}
			 */
			reviewType: {
				type: String,
				required: true,
			},

			/**
			 * The feedback collection on the parent review
			 * @type {Array}
			 */
			feedback: {
				type: Array,
				required: true,
			},
		},

		/**
		 * Fetch the user's IP address for comparaison
		 */
		created() {
			Fetcher.ip(this);
		},
		computed: {
			/**
			 * Checks if the device is a phone
			 * @return {Boolean} 
			 */
			deviceIsAPhone() {
				return window.innerWidth < 710;
			},

			/**
			 * Count the number of positive votes
			 * @return {Number} 
			 */
			positiveVotes() {
				return this.feedback.filter(({positive}) => positive).length;
			},

			/**
			 * Count the number of negative votes
			 * @return {Number} 
			 */
			negativeVotes() {
				return this.feedback.filter(({positive}) => !positive).length;
			},

			/**
			 * Get the user's IP address
			 * @return {String} 
			 */
			ipAddress() {
				return this.$store.state.ip.ipAddress;
			}
		},
		methods: {
			reviewWasHelpful(positive) {
				const formData = {positive, review_id: this.itemId};

				saveProfessorReviewFeedback(formData)
				.then(({data}) => this.$emit('change', data))
				.catch(res => console.log(res));
			},

			/**
			 * Checks if the user has casted a vote on this review
			 * @param {Boolean} voteToCheck The vote to check against
			 * @return {Boolean} 
			 */
			didUserVote(voteToCheck) {
				const res = this.feedback.find(feedback => feedback.ip_address == this.ipAddress);
				return res && res.positive == voteToCheck;
			},
		},
	};
</script>

<style>
	.section-container {
		text-align: right;
		color: #000;
		font-size: .9em;
	}
	.was-helpful {
		margin-right: 2em;
	}
	.was-helpful, .not-helpful {
		line-height: 40px;
	}
	.was-helpful:hover, .selected-positive {
		color: green !important;
	}
	.not-helpful:hover, .selected-negative {
		color: red !important;
	}
</style>