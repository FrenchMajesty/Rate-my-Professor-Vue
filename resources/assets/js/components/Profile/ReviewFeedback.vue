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
			itemId: {
				type: Number,
				required: true,
			},
			positiveVotes: {
				type: Number,
				default: 0,
			},
			negativeVotes: {
				type: Number,
				default: 0,
			},
		},
		computed: {
			deviceIsAPhone() {
				return window.innerWidth < 710;
			},
		},
		methods: {
			reviewWasHelpful(positiveVote) {
				this.$emit('leaveFeedback', positiveVote);
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