<?php
    $datas = file_get_contents('topmessage.json');
    $decodedData = json_decode($datas, true);

    $countedMessageSent = 0;
    $countedMessageRecheived = 0;
    $averageSentWord = 0;
    $averageReceivedWord = 0;

    $countSent = [];
    $nArraySent = 0;
    $countRecei = [];
    $nArrayRecei = 0;

    $getAllWord = [];
    foreach ($decodedData as $data) {
        foreach ($data as $miniData) {
            // print_r($miniData);
            if($miniData['sender'] == 'user1'){
                $countedMessageSent++;
            }
            if($miniData['recipient'] == 'user1'){
                $countedMessageRecheived++;
            }
            if($miniData['content'] && $miniData['sender'] == 'user1'){
                $messageSent = $miniData['content'];
                $nArraySent++;
                $countSent[] = str_word_count($messageSent);
            }
            if($miniData['content'] && $miniData['recipient'] == 'user1'){
                $messageReceiv = $miniData['content'];
                // print_r($message);
                $nArrayRecei++;
                $countRecei[] = str_word_count($messageReceiv);
            }

            $getAllWord[] = explode(' ', $miniData['content']);
        }
    }
    $sumCountSent = array_sum($countSent);
    $averageCountSent = ceil($sumCountSent / $nArraySent);
    $sumCountRecei = array_sum($countRecei);
    $averageCountRecei = ceil($sumCountRecei / $nArrayRecei);
    
    $mergeAllWord = [];
    foreach ($getAllWord as $gaw) {
        $mergeAllWord = array_merge($mergeAllWord,$gaw);
    }
    
    // [[l:9],[b:4],[c:8]]
    // [l:9,b:4,c:8]
    $topWord = array_merge(...array_map(fn($s)=>[$s=>count(array_filter($mergeAllWord, fn($e)=>$s==$e))], $mergeAllWord));
    arsort($topWord);

    print_r($topWord);
        
    
    // echo "<p>$sumCountSent</p>";
    echo "<ul>";
    echo "<li> Total message sent: $countedMessageSent</li>";
    echo "<li> Total message received: $countedMessageRecheived</li>";
    echo "<li> Average charachter length sent: $averageCountSent</li>";
    echo "<li> Average charachter length received: $averageCountRecei</li>";
    echo "</ul>";