#include <stdlib.h>
#include <stdio.h>
#include <pthread.h>

#include <unistd.h>
#include <stdarg.h>
#include <sys/types.h>
#include <sys/wait.h>

void* thread(void* args) {
	printf("this is a pthread\n");
	sleep(10);
}

int main(int argc, char * argv[]) {
	pthread_t id;
	int i,ret;
	ret = pthread_create(&id,NULL,thread,NULL);
	   sleep(1);  
	if(ret!=0) {
		printf("Create pthread error\n");
		exit(1);
	}

	printf("this is main process\n");
	pthread_join(id,NULL);
	return (0);
}
