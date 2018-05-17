#include <sys/types.h>
#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>

#include <time.h>

#include <stdarg.h>

#include <sys/wait.h>


int main(int argc,char ** argv) {
	pid_t pid;
	pid = fork();
	if(pid<0) {
		printf("error\n");
	} else if(pid == 0 ) {
		printf("a child\n");
		char *argv[]={"ls", "-al","/etc/passwd",NULL};
		char *envp[]={"PATH=/bin/",NULL};
		execve("/bin/ls",argv,envp);
		printf("this printf not exec");
		
	} else {
		printf("this is parent,the chuld --id=%d\n",pid);
		getchar();
		
	}
	return 0;
}
