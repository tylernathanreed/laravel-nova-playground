<template>
    <subdropdown v-if="group.actions.length > 0">
        <subdropdown-trigger class="cursor-pointer text-80 hover:text-primary hover:bg-30 p-3 flex items-center no-underline rounded-lg" slot-scope="{toggle}" :handle-click="toggle">
            <icon
                :type="icon.type"
                class="mr-3"
                :width="icon.width"
                :height="icon.height"
                :view-box="icon.viewBox"
            />
            <div v-text="__(group.name)" class="flex-1"></div>
        </subdropdown-trigger>

        <subdropdown-menu slot="menu" width="200" pull="left">
            <div>
                <component
                    v-for="(action, index) in group.actions"
                    :key="`resource-action-${depth + 1}-${index}`"
                    :depth="depth + 1"
                    :is="action.actions ? 'action-group' : 'action-item'"
                    :testId="testId"
                    :resource="resource"
                    :selected-resources="selectedResources"
                    :resource-name="resourceName"
                    :pivot-name="pivotName"
                    :action="action"
                    :relationship-type="relationshipType"
                    :via-relationship="viaRelationship"
                    :via-resource="viaResource"
                    :via-resource-id="viaResourceId"
                    :via-many-to-many="viaManyToMany"
                    @onActionSelected="onActionSelected"
                />
            </div>
        </subdropdown-menu>
    </subdropdown>
</template>

<script>
import { InteractsWithResourceInformation } from 'laravel-nova'

export default {

	props: {
		testId: String,
        depth: Number,
		action: Object,
		resource: Object,
        selectedResources: {
            type: [Array, String],
            default: () => [],
        },
		resourceName: String,
        pivotName: String,
        relationshipType: {
            type: String,
            default: null,
        },
		viaRelationship: String,
		viaResource: String,
		viaResourceId: String,
        viaManyToMany: Boolean
    },

    methods: {

    	/**
    	 * Propagates the action selected event.
    	 *
         * @param  {Object}   action
         * @param  {boolean}  isPivotAction
         *
    	 * @return void
    	 */
    	onActionSelected: function(action, isPivotAction) {
    		this.$emit('onActionSelected', action, isPivotAction);
    	}

    },

    computed: {

    	icon: function() {

    		// Determine the icon size
    		var width = Array.isArray(this.group.iconSize) ? this.group.iconSize[0] : 20;
    		var height = Array.isArray(this.group.iconSize) ? this.group.iconSize[1] : 20;

    		// Determine the icon box size
    		var boxXOffset = Array.isArray(this.group.iconBox) ? this.group.iconBox[0] : 0;
    		var boxYOffset = Array.isArray(this.group.iconBox) ? this.group.iconBox[1] : 0;
    		var boxWidth = Array.isArray(this.group.iconBox) ? this.group.iconBox[2] : width;
    		var boxHeight = Array.isArray(this.group.iconBox) ? this.group.iconBox[3] : height;

    		// Return the icon
    		return {
    			type: this.group.icon || 'play',
    			width: width,
    			height: height,
    			viewBox: [boxXOffset, boxYOffset, boxWidth, boxHeight].join(' ')
    		};

    	},

        group: function() {
            return this.action;
        }

    }

}
</script>