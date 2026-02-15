<template>
	<div class="countdown">
	    <div class="time-unite created" :v-show="years">
	        <div class="time-unite-title">Y</div>
	        <div class="time-unite-value">{{ years }}</div>
	    </div>
	    <div class="time-unite created" v-show="months">
	        <div class="time-unite-title">Mois</div>
	        <div class="time-unite-value">{{ months }}</div>
	    </div>
	    <div class="time-unite created" v-show="days">
	        <div class="time-unite-title">Jours</div>
	        <div class="time-unite-value">{{ days }}</div>
	    </div>
	    <div class="time-unite created">
	        <div class="time-unite-title">Heures</div>
	        <div class="time-unite-value">{{ hours }}</div>
	    </div>
	    <div class="time-unite created">
	        <div class="time-unite-title">Minutes</div>
	        <div class="time-unite-value">{{ minutes }}</div>
	    </div>
	    <div class="time-unite created">
	        <div class="time-unite-title">Secondes</div>
	        <div class="time-unite-value">{{ seconds }}</div>
	    </div>
	</div>
</template>

<script>
	import moment from 'moment'

	export default {
		data () {
			return {
				actualTime: moment().format('X'),
				years: 0,
				months: 0,
				days: 0,
				hours: 0,
				minutes: 0,
				seconds: 0
			}
		},
		methods: {
		  addOneSecondToActualTimeEverySecond () {
		      var component = this
		      component.actualTime = moment().format('X')
		      setTimeout(function(){
		          component.addOneSecondToActualTimeEverySecond()
		      }, 1000);
		  },
		  getDiffInSeconds () {
		    return moment("2016-10-21 22:00:00").format('X') - this.actualTime
		  },
		  compute () {
		    var duration = moment.duration(this.getDiffInSeconds(), "seconds")
		    this.years = duration.years() > 0 ? duration.years() : 0
		    this.months = duration.months() > 0 ? duration.months() : 0
		    this.days = duration.days() > 0 ? duration.days() : 0
		    this.hours = duration.hours() > 0 ? duration.hours() : 0
		    this.minutes = duration.minutes() > 0 ? duration.minutes() : 0
		    this.seconds = duration.seconds() > 0 ? duration.seconds() : 0
		  }
		},
		created () {
		  this.compute()
		  this.addOneSecondToActualTimeEverySecond()
		},
		watch: {
		    actualTime (val,oldVal) {
		        this.compute()
		    }
		}
	}
</script>