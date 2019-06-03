<?php

// No direct access
defined('_JEXEC') or die;
$component_id=$component_id[0]->value;
?>

<head>
	<script type="text/javascript" src="https://bis-adventa.atlassian.net/s/d41d8cd98f00b204e9800998ecf8427e-T/-vtewsn/100023/c/1000.0.11/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs.js?locale=es-ES&collectorId=c376f083"></script>

	<script type="text/javascript">
	var component_id='<?php echo$component_id;?>'
		window.ATL_JQ_PAGE_PROPS =  {
			"triggerFunction": function(showCollectorDialog) {

				jQuery("#feedback-button").click(function(e) {
					e.preventDefault();
					showCollectorDialog();
				});
			},
			fieldValues: {
				components : component_id
			}
		};
	</script>

</head>
<body>
	<a href="#" id="feedback-button" class='fa fa-support'></a>  Ayuda
</body>
