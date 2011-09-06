<?php if (is_array($tickets)) { ?>
<?php if (isset($ticketsheader)) { echo "<div class=\"tickets_header\">$ticketsheader</div>"; } ?>
<table width="100%" cellpadding="2" border="0">
  <tr bgcolor>
    <td width="40"><?php echo lang("ticket") ?></td>
    <td><?php echo lang("summary") ?></td>
    <td width="95"><?php echo lang("type") ?></td>
    <td width="60"><?php echo lang("state") ?></td>
    <td width="115"><?php echo lang("category") ?></td>
    <td width="60" align="center"><?php echo ucfirst(lang("created by")) ?></td>
    <td width="60" align="center"><?php echo lang("assigned to") ?></td>
  </tr>
<?php foreach($tickets as $ticket) { ?>
  <tr class="<?php echo $ticket->getPriority(); ?>">
    <td><div><a href="<?php echo $ticket->getViewUrl() ?>"><?php echo $ticket->getId() ?></a></div></td>
    <td><?php echo $ticket->getSummary() ?></td>
    <td><?php echo lang($ticket->getType()) ?></td>
    <td><?php echo lang($ticket->getState()) ?></td>
    <td>
<?php if($ticket->getCategory()) { ?>
          <?php echo clean($ticket->getCategory()->getName()) ?>
<?php } // if{ ?>
    </td>
    <td><?php echo $ticket->getCreatedBy()->getDisplayName() ?></td>
    <td>
<?php if($ticket->getAssignedTo()) { ?>
          <?php echo clean($ticket->getAssignedTo()->getObjectName()) ?>
<?php } // if{ ?>
    </td>
  </tr>
<?php } // foreach ?>
</table>
<?php } // if{ ?>
