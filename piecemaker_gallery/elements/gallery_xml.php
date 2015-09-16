<Piecemaker>
  <Contents>
    <?php foreach ($gallery as $image) : ?>
    <Image Source="<?php echo $image['src']?>" Title="<?php echo $image['title']?>">
      <?php if ($image['desc']) : ?><Text><?php  echo $tex->TextileThis($image['desc'])?></Text><?php endif ?>
      <?php   if ($image['link']):?><Hyperlink URL="<?php echo $image['link']?>" Target="_blank" /><?php endif ?>
    </Image>
    <?php endforeach ?>
  </Contents>
  <Settings InfoBackgroundAlpha="0.95"
            InfoMargin="25"
            DropShadowBlurX="4"
            DropShadowBlurY="4"
            ControlAlpha="0.8"
            ControlAlphaOver="0.95"
            TooltipTextY="5"
            TooltipMarginLeft="10"
            TooltipMarginRight="10"
            TooltipTextStyle="P-Italic"
            ControlsAlign="center"
            ControlsX="<?php echo $block->width/2 ?>"
            ControlsY="<?php echo $block->height/2 ?>"
            FieldOfView="45" ImageWidth="<?php echo $block->width ?>"
            ImageHeight="<?php echo $block->height ?>"
            Autoplay ="<?php echo $options[0]?>"
            LoaderColor="0x<?php echo $options[1]?>"
            DropShadowAlpha="<?php echo $options[2]?>"
            DropShadowDistance="<?php echo $options[3]?>"
            DropShadowScale ="<?php echo $options[4]?>"
            MenuDistanceX="<?php echo $options[5]?>"
            MenuDistanceY="<?php echo $options[6]?>"
            MenuColor1="0x<?php echo $options[7]?>"
            MenuColor2="0x<?php echo $options[8]?>"
            MenuColor3="0x<?php echo $options[9]?>"
            ControlSize="<?php echo $options[10]?>"
            ControlDistance="<?php echo $options[11]?>"
            ControlColor1="0x<?php echo $options[12]?>"
            ControlColor2= "0x<?php echo $options[13]?>"
            TooltipHeight = "<?php echo $options[15]?>"
            TooltipColor = "0x<?php echo $options[16]?>"
            TooltipTextColor = "0x<?php echo $options[17]?>"
            InfoWidth = "<?php echo $options[18]?>"
            InfoBackground="0x<?php echo $options[19]?>">
  </Settings>
  <Transitions>
    <?php foreach ($transitions as $t) :
    $t = explode(',',$t) ?>
    <Transition Pieces="<?php echo $t[0]?>" Time="<?php echo $t[1]?>" Transition="<?php echo $t[2]?>" Delay="<?php echo $t[3]?>" DepthOffset="<?php echo $t[4]?>" CubeDistance="<?php echo $t[5]?>"></Transition>
    <?php endforeach ?>
  </Transitions>
</Piecemaker>