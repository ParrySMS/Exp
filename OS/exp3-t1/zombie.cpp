#include <sys/types.h>
#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>

#include <time.h>

#include <stdarg.h>

#include <sys/wait.h>


int main() {
	pid_t pid;
	pid = fork();
	if(pid<0) {
		printf("error\n");
	}else if(pid ==0 ){
		printf("here is zombie child\n");
		exit(0);
	}else{
		sleep(3);
		waitpid(pid,NULL,0);
	}
	return 0;
}
