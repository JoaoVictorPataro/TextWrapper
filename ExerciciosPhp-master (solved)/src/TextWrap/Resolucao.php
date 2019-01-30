<?php

namespace Galoa\ExerciciosPhp\TextWrap;

/**
 * Implemente sua resolução aqui.
 */

class Resolucao implements TextWrapInterface {

  /**
   * {@inheritdoc}
   */
	public function textWrap(string $text, int $length): array
  	{
	  	$retArray = [];		//creates return array
		if (empty($text))			//if the received text is empty
	    {
	  		$retArray[0] = NULL;		//we create a null position in the array
	    	return $retArray;			//and send it back
	    }

	    $linesIndex = 0;
	    $currentCharacter;
	    $index = 0;
	    $end = false;
	    $lineArray = [];
	    $lineIndex = 0;				//iniciates all variables we will need in the function

	    $stringLine;

	    while ($end == false)		//and while it is not the end of the proccess
	    {
	        $stringLine = "";
	        $wordArray = [];		//we create a word array to read the current word
	        $wordIndex = 0;
	        if ($index >= strlen($text))		//if the index is higher than the length of the text
	            $end = true;			//it means we are over, and then, we set $end to true
	        else
	        {
	            $currentCharacter = substr($text, $index, 1);		//we read the current character
	            while ($currentCharacter != " " && $end == false)		//and if it is not a space and it is not the end
	            {
	                $wordArray[$wordIndex] = $currentCharacter;		//we put this character in the word array
	                $wordIndex++;
	                $index++;
	                if ($index == strlen($text))			//if we have reached the end of the text
	                    $end = true;				//we end it all
	                else
	                    $currentCharacter = substr($text, $index, 1);
	            }
	            $index++;		//here, we count one more on the index so the next time we read another character it is not the same
	            				//as the previous time
	            if ($wordIndex > $length)		//if the word is bigger than the length of the line, we will split it in two or more
	            {
	                for ($i = 0; $i < count($wordArray); $i++)		//while we still have to write the word in the lines
	                {
	                    $lineArray[$lineIndex] = $wordArray[$i];		//we do it
	                    $lineIndex++;
	                    if ($lineIndex == $length)		//and if the line is over
	                    {
	                        for ($j = 0; $j < count($lineArray); $j++)
	                            $stringLine = $stringLine . $lineArray[$j];

	                        if (substr($stringLine, (strlen($stringLine) - 1), 1) == " ")
	                            $stringLine = substr($stringLine, 0, -1);

	                        $retArray[$linesIndex] = $stringLine;		//we copy the finished line into the return array
	                        $linesIndex++;
	                        unset($lineArray);						//and create another line
	                        $stringLine = "";
	                        $lineArray = [];
	                        $lineIndex = 0;
	                    }
	                }
	            }
	            else						//else, if the current word is not bigger than the line
	            {
	                if ($wordIndex > ($length - $lineIndex))		//but bigger than the space we have left in the current line
	                {
	                    for ($j = 0; $j < count($lineArray); $j++)
	                        $stringLine = $stringLine . $lineArray[$j];

	                    if (substr($stringLine, (strlen($stringLine) - 1), 1) == " ")
	                        $stringLine = substr($stringLine, 0, -1);

	                    $retArray[$linesIndex] = $stringLine;		//we copy this 'finished' line to the return array
	                    $linesIndex++;
	                    unset($lineArray);						//and create another line
	                    $lineIndex = 0;
	                }
	                for ($i = 0; $i < $wordIndex; $i++)
	                {
	                    $lineArray[$lineIndex] = $wordArray[$i];			//then, we copy the entire word into the next line
	                    $lineIndex++;
	                }
	            }
	            if ($lineIndex < $length - 1 && $end == false)		//and if necessary, we copy the space into the line
	            {
	                $lineArray[$lineIndex] = " ";
	                $lineIndex++;
	            }
	        }
	    }

	    $stringLine = "";

	    for ($j = 0; $j < count($lineArray); $j++)
	        $stringLine = $stringLine . $lineArray[$j];

	    if (substr($stringLine, (strlen($stringLine) - 1), 1) == " ")
	        $stringLine = substr($stringLine, 0, -1);

	    $retArray[$linesIndex] = $stringLine;		//in the end, we copy the last line into the return array
	    $linesIndex++;
	    return $retArray;							//and return it
	}


}