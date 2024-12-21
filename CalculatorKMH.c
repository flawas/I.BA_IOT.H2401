#include <stdio.h>
#include <tgmath.h>

int main(void) {
    float mph;
    for(mph = 5.0; mph <= 100; mph += 5) {
        float kmh = mph * 1.609344;
        printf("%.1f mph      %.1f kmh\n", mph, kmh);
    }

    
    return 0;
}
