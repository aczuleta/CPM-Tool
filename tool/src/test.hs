doubleMe x = x + x
doubleUs x y = x * 2 + y * 2
doubleUs' x y = doubleMe x + doubleMe y



iterate l1 li result =
    let ini = 0
        max = longi length
        index = li !! ini
    in result ++ [l1 !! index]
    iterate l1 li ini