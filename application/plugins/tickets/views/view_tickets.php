<?php if (is_array($tickets)) { ?>
<div class="block">
<?php if (isset($ticketsheader)) { echo "<div class=\"header\">$ticketsheader</div>"; } ?>
<div class="content"><table>
  <tr bgcolor>
    <th width="40"><?php echo lang("ticket") ?></td>
    <th><?php echo lang("summary") ?></td>
    <th width="95"><?php echo lang("type") ?></td>
    <th width="60"><?php echo lang("state") ?></td>
    <th width="115"><?php echo lang("category") ?></td>
    <th width="60" align="center"><?php echo ucfirst(lang("created by")) ?></td>
    <th width="60" align="center"><?php echo lang("assigned to") ?></td>
  </tr>
<?php foreach($tickets as $ticket) { ?>
  <tr class="<?php echo $ticket->getPriority(); ?>">
    <td><div><a href="<?php echo $ticket->getViewUrl() ?>"><?php echo $ticket->getId() ?></a></div></td>
    <td class="summary"><?php echo $ticket->getSummary() ?></td>
    <td><?php echo lang($ticket->getType()) ?></td>
    <td><?php echo lang($ticket->getState()) ?></td>
    <td>
<?php if($ticket->getCategory()) { ?>
          <?php echo clean($ticket->getCategory()->getName()) ?>
<?php } // if{ ?>
    </td>
    <td><?php if (!is_null($ticket->getCreatedBy())) echo $ticket->getCreatedBy()->getDisplayName() ?></td>
    <td>
<?php if($ticket->getAssignedTo()) { ?>
          <?php echo clean($ticket->getAssignedTo()->getObjectName()) ?>
<?php } // if{ ?>
    </td>
  </tr>
<?php } // foreach ?>
</table></div></div>
<?php } // if{ ?>
