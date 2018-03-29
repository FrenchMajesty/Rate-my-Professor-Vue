<template>
	<div>
		<md-progress-bar 
				v-if="routeIsChanging"
				md-mode="determinate" 
				:md-value="amount"
				class="fixed-top"
				style="position: fixed; z-index: 1040"
			></md-progress-bar>
		<Navbar></Navbar>
		<div class="space-above">

			<transition
	            enter-active-class="animated fadeIn"
	            leave-active-class="animated fadeOut"
			>
				<router-view></router-view>
			</transition>
		</div>
	</div>
</template>

<script>
	import Navbar from './components/common/Navbar';

	export default {
		name: 'AppWrapper',
		components: {
			Navbar,
		},
		data() {
			return {
				/**
				 * Status of the change in route
				 * @type {Boolean}
				 */
				routeIsChanging: false,

				/**
				 * The amount of the progress bar
				 * @type {Number}
				 */
				amount: 0,

				/**
				 * The ID of the interval updating the progress bar's amount
				 * @type {Number}
				 */
				intervalId: null,
			};
		},
		methods: {
			/**
			 * Start the interval for the progress bar
			 * @return {Void} 
			 */
			startLoadingBar() {
				this.routeIsChanging = true;
				this.intervalId = setInterval(() => {
					this.amount += 4;
				}, 5);
			}
		},
		watch: {
			/**
			 * Watch the change of route to animate the progress bar
			 * @return {Void}      
			 */
			$route: function() {
				this.startLoadingBar();
			},

			/**
			 * Watch the loading status to turn it off when it reaches 100%
			 * @param  {Number} newValue New value of the progress bar's amount
			 * @return {Void}          
			 */
			amount: function(newValue) {
				if(newValue >= 100) {
					clearInterval(this.intervalId);
					this.routeIsChanging = false;
					this.amount = 0;
				}
			},
		}
	}
</script>