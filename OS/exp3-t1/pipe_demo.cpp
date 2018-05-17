#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include <unistd.h>
#include <stdarg.h>
#include <sys/types.h>
#include <sys/wait.h>
int main(){
	
	pid_t pid = 0;
	int fds[2];
	char buf[128];
	int nwr = 0;
	
	pipe(fds);
	
	pid = fork();
	
	if(pid<0){
		printf("fork error\n");
		return -1;	
	}else if(pid == 0){
		//child
		printf("this is child,pid == %d\n",getpid());
		printf("Child: waiting...\n");
		close(fds[1]);
		nwr = read(fds[0],buf,sizeof(buf));
		printf("Child:read msg |-- \n %s \n --|\n ",buf);
	}else{
		//parent 
		printf("this is parent,pid == %d\n",getpid());
		printf("Parent: waiting...\n");
		close(fds[0]);
		strcpy(buf,"A msg from par!!\n");
		nwr = write(fds[1],buf,sizeof(buf));
		printf("Parent:sent %d byte to child\n",nwr);
	}
	return 0;
}
