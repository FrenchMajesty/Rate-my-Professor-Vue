<template>
	<div class="section-container">
		<span class="was-helpful" @click="reviewWasHelpful(true)">
			<md-button class="md-icon-button">
		    	<md-icon>thumb_up</md-icon>
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
		    	<md-icon>thumb_down</md-icon>
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

	export default {
		name: 'ReviewFeedback',
		props: {
			/**
			 * The ID of the review for the feeback
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
			}
		},
		methods: {
			reviewWasHelpful(isVotePositive) {
				console.log('Submit form to change/set the vote!')
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
	.was-helpful:hover {
		color: green;
	}
	.not-helpful:hover {
		color: red;
	}
</style>